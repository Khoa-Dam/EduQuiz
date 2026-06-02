<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\Quiz;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class QuestionController extends Controller
{
    public function index(Request $request): View
    {
        $selectedQuizId = $request->integer('quiz_id') ?: null;
        $quizzes = Quiz::query()->with('course')->orderBy('title')->get();
        $questions = Question::query()
            ->with('quiz.course')
            ->withCount('answers')
            ->when($selectedQuizId, fn ($query) => $query->where('quiz_id', $selectedQuizId))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.questions.index', compact('questions', 'quizzes', 'selectedQuizId'));
    }

    public function create(): View
    {
        return view('admin.questions.create', [
            'question' => new Question(),
            'quizzes' => Quiz::query()->with('course')->orderBy('title')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatedData($request);

        if ($request->hasFile('question_image')) {
            $data['image_path'] = $request->file('question_image')->store('questions', 'public');
        }

        $question = Question::create($data);

        return redirect()
            ->route('admin.questions.show', $question)
            ->with('success', 'Question created successfully.');
    }

    public function show(Question $question): View
    {
        $question->load(['quiz.course', 'answers']);

        return view('admin.questions.show', compact('question'));
    }

    public function edit(Question $question): View
    {
        return view('admin.questions.edit', [
            'question' => $question,
            'quizzes' => Quiz::query()->with('course')->orderBy('title')->get(),
        ]);
    }

    public function update(Request $request, Question $question): RedirectResponse
    {
        $data = $this->validatedData($request);

        if ($request->boolean('remove_question_image') && $question->image_path) {
            Storage::disk('public')->delete($question->image_path);
            $data['image_path'] = null;
        }

        if ($request->hasFile('question_image')) {
            if ($question->image_path) {
                Storage::disk('public')->delete($question->image_path);
            }

            $data['image_path'] = $request->file('question_image')->store('questions', 'public');
        }

        $question->update($data);

        return redirect()
            ->route('admin.questions.show', $question)
            ->with('success', 'Question updated successfully.');
    }

    public function destroy(Question $question): RedirectResponse
    {
        if ($question->image_path) {
            Storage::disk('public')->delete($question->image_path);
        }

        $question->delete();

        return redirect()
            ->route('admin.questions.index')
            ->with('success', 'Question deleted successfully.');
    }

    /**
     * @return array{quiz_id: int, question_text: string, points: int}
     */
    private function validatedData(Request $request): array
    {
        $data = $request->validate([
            'quiz_id' => ['required', 'integer', 'exists:quizzes,id'],
            'question_text' => ['required', 'string'],
            'question_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'remove_question_image' => ['nullable', 'boolean'],
            'points' => ['required', 'integer', 'min:1', 'max:100'],
        ]);

        unset($data['question_image'], $data['remove_question_image']);

        return $data;
    }
}
