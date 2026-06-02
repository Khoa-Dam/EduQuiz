<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class CourseController extends Controller
{
    private const STATUSES = [
        'active' => 'Active',
        'inactive' => 'Inactive',
    ];

    public function index(): View
    {
        $courses = Course::query()
            ->latest()
            ->paginate(10);

        return view('admin.courses.index', compact('courses'));
    }

    public function create(): View
    {
        return view('admin.courses.create', [
            'course' => new Course(),
            'statuses' => self::STATUSES,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $course = Course::create($this->validatedData($request));

        return redirect()
            ->route('admin.courses.show', $course)
            ->with('success', 'Course created successfully.');
    }

    public function show(Course $course): View
    {
        return view('admin.courses.show', compact('course'));
    }

    public function edit(Course $course): View
    {
        return view('admin.courses.edit', [
            'course' => $course,
            'statuses' => self::STATUSES,
        ]);
    }

    public function update(Request $request, Course $course): RedirectResponse
    {
        $course->update($this->validatedData($request));

        return redirect()
            ->route('admin.courses.show', $course)
            ->with('success', 'Course updated successfully.');
    }

    public function destroy(Course $course): RedirectResponse
    {
        $course->delete();

        return redirect()
            ->route('admin.courses.index')
            ->with('success', 'Course deleted successfully.');
    }

    /**
     * @return array{title: string, description?: string|null, status: string}
     */
    private function validatedData(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'status' => ['required', 'string', Rule::in(array_keys(self::STATUSES))],
        ]);
    }
}
