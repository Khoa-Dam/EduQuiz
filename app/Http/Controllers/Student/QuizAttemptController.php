<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class QuizAttemptController extends Controller
{
    public function store(Request $request, Quiz $quiz): RedirectResponse
    {
        $this->ensureQuizIsAvailable($quiz);

        $quiz->load(['questions.answers']);
        $this->validateSubmittedAnswers($request, $quiz);

        $attempt = DB::transaction(function () use ($request, $quiz): QuizAttempt {
            $score = 0;
            $correctAnswers = 0;

            $attempt = QuizAttempt::create([
                'user_id' => $request->user()->id,
                'quiz_id' => $quiz->id,
                'score' => 0,
                'total_questions' => $quiz->questions->count(),
                'correct_answers' => 0,
                'started_at' => now(),
                'submitted_at' => now(),
            ]);

            foreach ($quiz->questions as $question) {
                $answer = Answer::where('question_id', $question->id)
                    ->whereKey((int) $request->input("answers.{$question->id}"))
                    ->firstOrFail();

                $isCorrect = $answer->is_correct;

                if ($isCorrect) {
                    $correctAnswers++;
                    $score += $question->points ?: 1;
                }

                $attempt->attemptAnswers()->create([
                    'question_id' => $question->id,
                    'answer_id' => $answer->id,
                    'is_correct' => $isCorrect,
                ]);
            }

            $attempt->update([
                'score' => $score,
                'correct_answers' => $correctAnswers,
            ]);

            return $attempt;
        });

        return redirect()
            ->route('quizzes.show', $quiz)
            ->with('success', "Quiz submitted. Score: {$attempt->score}.");
    }

    private function ensureQuizIsAvailable(Quiz $quiz): void
    {
        $quiz->loadMissing('course');

        abort_unless($quiz->status === 'active' && $quiz->course->status === 'active', 404);
    }

    private function validateSubmittedAnswers(Request $request, Quiz $quiz): void
    {
        $rules = [];

        foreach ($quiz->questions as $question) {
            $rules["answers.{$question->id}"] = ['required', 'integer', 'exists:answers,id'];
        }

        $request->validate($rules);

        foreach ($quiz->questions as $question) {
            $answerBelongsToQuestion = $question->answers
                ->contains('id', (int) $request->input("answers.{$question->id}"));

            if (! $answerBelongsToQuestion) {
                throw ValidationException::withMessages([
                    "answers.{$question->id}" => 'The selected answer does not belong to this question.',
                ]);
            }
        }
    }
}
