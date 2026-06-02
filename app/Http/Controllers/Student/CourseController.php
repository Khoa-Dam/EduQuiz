<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\View\View;

class CourseController extends Controller
{
    public function index(): View
    {
        $courses = Course::query()
            ->where('status', 'active')
            ->latest()
            ->paginate(10);

        return view('student.courses.index', compact('courses'));
    }

    public function show(Course $course): View
    {
        abort_unless($course->status === 'active', 404);

        $course->load(['quizzes' => fn ($query) => $query->where('status', 'active')->latest()]);

        return view('student.courses.show', compact('course'));
    }
}
