<?php

namespace App\Services;

use App\Models\Answer;
use App\Models\Course;
use App\Models\Question;
use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class QuizBuilderService
{
    /**
     * @var list<string>
     */
    private array $storedPaths = [];

    /**
     * @var list<string>
     */
    private array $pathsToDeleteAfterCommit = [];

    public function __construct(private readonly QuizReadinessService $readiness)
    {
    }

    /**
     * @param array<string, mixed> $data
     */
    public function create(Request $request, array $data): Quiz
    {
        return $this->saveWithFileCleanup(function () use ($request, $data): Quiz {
            $quiz = DB::transaction(function () use ($request, $data): Quiz {
                $course = $this->resolveCourse($data);

                $quiz = Quiz::create([
                    'course_id' => $course->id,
                    'title' => $data['title'],
                    'description' => $data['description'] ?? null,
                    'duration_minutes' => $data['duration_minutes'] ?? null,
                    'status' => 'inactive',
                ]);

                if ($request->hasFile('cover_image')) {
                    $quiz->update([
                        'cover_image_path' => $this->storeFile($request, 'cover_image', 'quizzes'),
                    ]);
                }

                $this->syncQuestions($request, $quiz);

                if (($data['intent'] ?? 'save') === 'publish') {
                    $this->publishOrFail($quiz);
                }

                return $quiz;
            });

            $this->deleteQueuedOldFiles();

            return $quiz;
        });
    }

    /**
     * @param array<string, mixed> $data
     */
    public function update(Request $request, array $data, Quiz $quiz): Quiz
    {
        return $this->saveWithFileCleanup(function () use ($request, $data, $quiz): Quiz {
            $quiz = DB::transaction(function () use ($request, $data, $quiz): Quiz {
                $course = $this->resolveCourse($data);
                $originalStatus = $quiz->status;

                if ($request->boolean('remove_cover_image') && $quiz->cover_image_path) {
                    $this->queueOldFileDeletion($quiz->cover_image_path);
                    $quiz->cover_image_path = null;
                }

                if ($request->hasFile('cover_image')) {
                    if ($quiz->cover_image_path) {
                        $this->queueOldFileDeletion($quiz->cover_image_path);
                    }

                    $quiz->cover_image_path = $this->storeFile($request, 'cover_image', 'quizzes');
                }

                $quiz->fill([
                    'course_id' => $course->id,
                    'title' => $data['title'],
                    'description' => $data['description'] ?? null,
                    'duration_minutes' => $data['duration_minutes'] ?? null,
                    'status' => $this->nextStatusBeforeReadinessCheck($data['intent'] ?? 'save', $originalStatus),
                ])->save();

                $this->syncQuestions($request, $quiz);

                match ($data['intent'] ?? 'save') {
                    'publish' => $this->publishOrFail($quiz),
                    'save' => $this->keepActiveOnlyIfReady($quiz, $originalStatus),
                    default => null,
                };

                return $quiz;
            });

            $this->deleteQueuedOldFiles();

            return $quiz->refresh();
        });
    }

    /**
     * @param callable(): Quiz $callback
     */
    private function saveWithFileCleanup(callable $callback): Quiz
    {
        $this->storedPaths = [];
        $this->pathsToDeleteAfterCommit = [];

        try {
            return $callback();
        } catch (\Throwable $throwable) {
            foreach ($this->storedPaths as $path) {
                Storage::disk('public')->delete($path);
            }

            throw $throwable;
        }
    }

    /**
     * @param array<string, mixed> $data
     */
    private function resolveCourse(array $data): Course
    {
        if (($data['course_mode'] ?? null) === 'new') {
            return Course::create([
                'title' => $data['course_title'],
                'description' => $data['course_description'] ?? null,
                'status' => 'active',
            ]);
        }

        return Course::findOrFail((int) $data['course_id']);
    }

    private function syncQuestions(Request $request, Quiz $quiz): void
    {
        $submittedQuestions = collect($request->input('questions', []))
            ->filter(fn (array $question): bool => filled($question['question_text'] ?? null))
            ->values();
        $keptQuestionIds = [];

        foreach ($submittedQuestions as $index => $questionData) {
            $question = isset($questionData['id'])
                ? Question::where('quiz_id', $quiz->id)->findOrFail((int) $questionData['id'])
                : new Question(['quiz_id' => $quiz->id]);

            if ($request->boolean("questions.{$index}.remove_question_image") && $question->image_path) {
                $this->queueOldFileDeletion($question->image_path);
                $question->image_path = null;
            }

            if ($request->hasFile("questions.{$index}.question_image")) {
                if ($question->image_path) {
                    $this->queueOldFileDeletion($question->image_path);
                }

                $question->image_path = $this->storeFile($request, "questions.{$index}.question_image", 'questions');
            }

            $question->fill([
                'quiz_id' => $quiz->id,
                'question_text' => $questionData['question_text'],
                'points' => $questionData['points'] ?? 1,
            ])->save();

            $keptQuestionIds[] = $question->id;
            $this->syncAnswers($question, $questionData['answers'] ?? []);
        }

        $quiz->questions()
            ->whereNotIn('id', $keptQuestionIds ?: [0])
            ->get()
            ->each(function (Question $question): void {
                if ($question->image_path) {
                    $this->queueOldFileDeletion($question->image_path);
                }

                $question->delete();
            });
    }

    /**
     * @param array<int, array<string, mixed>> $answers
     */
    private function syncAnswers(Question $question, array $answers): void
    {
        $keptAnswerIds = [];

        foreach ($answers as $answerData) {
            if (! filled($answerData['answer_text'] ?? null)) {
                continue;
            }

            $answer = isset($answerData['id'])
                ? Answer::where('question_id', $question->id)->findOrFail((int) $answerData['id'])
                : new Answer(['question_id' => $question->id]);

            $answer->fill([
                'question_id' => $question->id,
                'answer_text' => $answerData['answer_text'],
                'is_correct' => (bool) ($answerData['is_correct'] ?? false),
            ])->save();

            $keptAnswerIds[] = $answer->id;
        }

        $question->answers()
            ->whereNotIn('id', $keptAnswerIds ?: [0])
            ->delete();
    }

    private function storeFile(Request $request, string $key, string $directory): string
    {
        $path = $request->file($key)->store($directory, 'public');
        $this->storedPaths[] = $path;

        return $path;
    }

    private function queueOldFileDeletion(string $path): void
    {
        $this->pathsToDeleteAfterCommit[] = $path;
    }

    private function deleteQueuedOldFiles(): void
    {
        foreach (array_unique($this->pathsToDeleteAfterCommit) as $path) {
            Storage::disk('public')->delete($path);
        }
    }

    private function nextStatusBeforeReadinessCheck(string $intent, string $originalStatus): string
    {
        return match ($intent) {
            'draft' => 'inactive',
            'publish' => 'inactive',
            default => $originalStatus,
        };
    }

    private function publishOrFail(Quiz $quiz): void
    {
        $quiz->load('questions.answers');
        $errors = $this->readiness->errors($quiz);

        if ($errors !== []) {
            throw ValidationException::withMessages([
                'publish' => $errors,
            ]);
        }

        $quiz->update(['status' => 'active']);
    }

    private function keepActiveOnlyIfReady(Quiz $quiz, string $originalStatus): void
    {
        if ($originalStatus !== 'active') {
            return;
        }

        $quiz->load('questions.answers');
        $errors = $this->readiness->errors($quiz);

        if ($errors !== []) {
            throw ValidationException::withMessages([
                'publish' => $errors,
            ]);
        }

        $quiz->update(['status' => 'active']);
    }
}
