<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Quiz;
use App\Services\QuizBuilderService;
use App\Services\QuizReadinessService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class QuizBuilderController extends Controller
{
    public function __construct(
        private readonly QuizBuilderService $builder,
        private readonly QuizReadinessService $readiness,
    )
    {
    }

    public function create(): View
    {
        return view('admin.quiz-builder.create', [
            'quiz' => new Quiz(),
            'courses' => Course::query()->orderBy('title')->get(),
            'builderQuestions' => collect(),
            'readinessErrors' => [],
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatedData($request);

        $quiz = $this->builder->create($request, $data);

        return redirect()
            ->route('admin.quiz-builder.edit', $quiz)
            ->with('success', $this->successMessage($data['intent'], $quiz));
    }

    public function edit(Quiz $quiz): View
    {
        $quiz->load(['course', 'questions.answers']);

        return view('admin.quiz-builder.edit', [
            'quiz' => $quiz,
            'courses' => Course::query()->orderBy('title')->get(),
            'builderQuestions' => $quiz->questions,
            'readinessErrors' => $this->readiness->errors($quiz),
        ]);
    }

    public function update(Request $request, Quiz $quiz): RedirectResponse
    {
        $data = $this->validatedData($request);
        $quiz = $this->builder->update($request, $data, $quiz);

        return redirect()
            ->route('admin.quiz-builder.edit', $quiz)
            ->with('success', $this->successMessage($data['intent'], $quiz));
    }

    /**
     * @return array<string, mixed>
     */
    private function validatedData(Request $request): array
    {
        return $request->validate([
            'intent' => ['required', Rule::in(['save', 'draft', 'publish'])],
            'course_mode' => ['required', Rule::in(['existing', 'new'])],
            'course_id' => ['required_if:course_mode,existing', 'nullable', 'integer', 'exists:courses,id'],
            'course_title' => ['required_if:course_mode,new', 'nullable', 'string', 'max:255'],
            'course_description' => ['nullable', 'string'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'cover_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'remove_cover_image' => ['nullable', 'boolean'],
            'duration_minutes' => ['nullable', 'integer', 'min:1', 'max:10080'],
            'questions' => ['nullable', 'array'],
            'questions.*.id' => ['nullable', 'integer', 'exists:questions,id'],
            'questions.*.question_text' => ['nullable', 'string'],
            'questions.*.points' => ['nullable', 'integer', 'min:1', 'max:100'],
            'questions.*.question_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'questions.*.remove_question_image' => ['nullable', 'boolean'],
            'questions.*.answers' => ['nullable', 'array'],
            'questions.*.answers.*.id' => ['nullable', 'integer', 'exists:answers,id'],
            'questions.*.answers.*.answer_text' => ['nullable', 'string'],
            'questions.*.answers.*.is_correct' => ['nullable', 'boolean'],
        ]);
    }

    private function successMessage(string $intent, Quiz $quiz): string
    {
        if ($intent === 'publish' || $quiz->status === 'active') {
            return 'Quiz published successfully.';
        }

        return $intent === 'draft'
            ? 'Quiz moved back to draft.'
            : 'Draft saved successfully.';
    }
}
