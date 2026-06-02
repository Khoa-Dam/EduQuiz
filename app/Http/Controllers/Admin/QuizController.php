<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Quiz;
use App\Services\QuizReadinessService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class QuizController extends Controller
{
    public function __construct(private readonly QuizReadinessService $readiness)
    {
    }

    private const STATUSES = [
        'active' => 'Active',
        'inactive' => 'Inactive',
    ];

    public function index(): View
    {
        $quizzes = Quiz::query()
            ->with(['course', 'questions.answers'])
            ->latest()
            ->paginate(10);
        $quizReadiness = $quizzes->getCollection()
            ->mapWithKeys(fn (Quiz $quiz): array => [$quiz->id => $this->readiness->isReady($quiz)]);

        return view('admin.quizzes.index', compact('quizzes', 'quizReadiness'));
    }

    public function create(): View
    {
        return view('admin.quizzes.create', [
            'quiz' => new Quiz(),
            'courses' => Course::query()->orderBy('title')->get(),
            'statuses' => self::STATUSES,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatedData($request);

        if (($data['status'] ?? null) === 'active') {
            throw ValidationException::withMessages([
                'status' => 'Use Quiz Builder to publish a quiz after adding questions and answers.',
            ]);
        }

        if ($request->hasFile('cover_image')) {
            $data['cover_image_path'] = $request->file('cover_image')->store('quizzes', 'public');
        }

        $quiz = Quiz::create($data);

        return redirect()
            ->route('admin.quizzes.show', $quiz)
            ->with('success', 'Quiz created successfully.');
    }

    public function show(Quiz $quiz): View
    {
        $quiz->load(['course', 'questions.answers']);

        return view('admin.quizzes.show', [
            'quiz' => $quiz,
            'readinessErrors' => $this->readiness->errors($quiz),
        ]);
    }

    public function edit(Quiz $quiz): View
    {
        return view('admin.quizzes.edit', [
            'quiz' => $quiz,
            'courses' => Course::query()->orderBy('title')->get(),
            'statuses' => self::STATUSES,
        ]);
    }

    public function update(Request $request, Quiz $quiz): RedirectResponse
    {
        $data = $this->validatedData($request);

        if ($request->boolean('remove_cover_image') && $quiz->cover_image_path) {
            Storage::disk('public')->delete($quiz->cover_image_path);
            $data['cover_image_path'] = null;
        }

        if ($request->hasFile('cover_image')) {
            if ($quiz->cover_image_path) {
                Storage::disk('public')->delete($quiz->cover_image_path);
            }

            $data['cover_image_path'] = $request->file('cover_image')->store('quizzes', 'public');
        }

        if (($data['status'] ?? null) === 'active' && ! $this->readiness->isReady($quiz)) {
            throw ValidationException::withMessages([
                'status' => $this->readiness->errors($quiz),
            ]);
        }

        $quiz->update($data);

        return redirect()
            ->route('admin.quizzes.show', $quiz)
            ->with('success', 'Quiz updated successfully.');
    }

    public function destroy(Quiz $quiz): RedirectResponse
    {
        if ($quiz->cover_image_path) {
            Storage::disk('public')->delete($quiz->cover_image_path);
        }

        $quiz->delete();

        return redirect()
            ->route('admin.quizzes.index')
            ->with('success', 'Quiz deleted successfully.');
    }

    /**
     * @return array{course_id: int, title: string, description?: string|null, duration_minutes?: int|null, status: string}
     */
    private function validatedData(Request $request): array
    {
        $data = $request->validate([
            'course_id' => ['required', 'integer', 'exists:courses,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'cover_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'remove_cover_image' => ['nullable', 'boolean'],
            'duration_minutes' => ['nullable', 'integer', 'min:1', 'max:10080'],
            'status' => ['required', 'string', Rule::in(array_keys(self::STATUSES))],
        ]);

        unset($data['cover_image'], $data['remove_cover_image']);

        return $data;
    }
}
