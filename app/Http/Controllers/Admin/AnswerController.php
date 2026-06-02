<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\Question;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class AnswerController extends Controller
{
    public function index(Request $request): View
    {
        $selectedQuestionId = $request->integer('question_id') ?: null;
        $questions = Question::query()->with('quiz')->orderBy('question_text')->get();
        $answers = Answer::query()
            ->with('question.quiz')
            ->when($selectedQuestionId, fn ($query) => $query->where('question_id', $selectedQuestionId))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.answers.index', compact('answers', 'questions', 'selectedQuestionId'));
    }

    public function create(Request $request): View
    {
        return view('admin.answers.create', [
            'answer' => new Answer(['question_id' => $request->integer('question_id') ?: null]),
            'questions' => Question::query()->with('quiz')->orderBy('question_text')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatedData($request);
        $question = Question::findOrFail($data['question_id']);

        $this->ensureQuestionKeepsCorrectAnswer($question, null, $data['is_correct']);

        $answer = Answer::create($data);

        return redirect()
            ->route('admin.questions.show', $answer->question)
            ->with('success', 'Answer created successfully.');
    }

    public function show(Answer $answer): View
    {
        $answer->load('question.quiz');

        return view('admin.answers.show', compact('answer'));
    }

    public function edit(Answer $answer): View
    {
        return view('admin.answers.edit', [
            'answer' => $answer,
            'questions' => Question::query()->with('quiz')->orderBy('question_text')->get(),
        ]);
    }

    public function update(Request $request, Answer $answer): RedirectResponse
    {
        $data = $this->validatedData($request);
        $newQuestion = Question::findOrFail($data['question_id']);

        if ($answer->question_id !== $newQuestion->id && $answer->is_correct) {
            $this->ensureQuestionKeepsCorrectAnswer($answer->question, $answer, false);
        }

        $this->ensureQuestionKeepsCorrectAnswer($newQuestion, $answer, $data['is_correct']);

        $answer->update($data);

        return redirect()
            ->route('admin.questions.show', $answer->question)
            ->with('success', 'Answer updated successfully.');
    }

    public function destroy(Answer $answer): RedirectResponse
    {
        if ($answer->is_correct && $answer->question->answers()->count() > 1) {
            $this->ensureQuestionKeepsCorrectAnswer($answer->question, $answer, false);
        }

        $question = $answer->question;
        $answer->delete();

        return redirect()
            ->route('admin.questions.show', $question)
            ->with('success', 'Answer deleted successfully.');
    }

    /**
     * @return array{question_id: int, answer_text: string, is_correct: bool}
     */
    private function validatedData(Request $request): array
    {
        $data = $request->validate([
            'question_id' => ['required', 'integer', 'exists:questions,id'],
            'answer_text' => ['required', 'string'],
            'is_correct' => ['nullable', 'boolean'],
        ]);

        $data['is_correct'] = $request->boolean('is_correct');

        return $data;
    }

    private function ensureQuestionKeepsCorrectAnswer(Question $question, ?Answer $answer, bool $willBeCorrect): void
    {
        if ($willBeCorrect) {
            return;
        }

        $hasOtherCorrectAnswer = $question->answers()
            ->when($answer, fn ($query) => $query->whereKeyNot($answer->id))
            ->where('is_correct', true)
            ->exists();

        if (! $hasOtherCorrectAnswer) {
            throw ValidationException::withMessages([
                'is_correct' => 'At least one correct answer is required for a question.',
            ]);
        }
    }
}
