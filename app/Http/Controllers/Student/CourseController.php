<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Services\QuizReadinessService;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\View\View;

class CourseController extends Controller
{
    public function __construct(private readonly QuizReadinessService $readiness)
    {
    }

    public function index(): View
    {
        $readyCourses = Course::query()
            ->where('status', 'active')
            ->whereHas('quizzes', function ($query): void {
                $query->where('status', 'active')
                    ->whereHas('questions.answers')
                    ->with('questions.answers');
            })
            ->latest()
            ->get()
            ->filter(function (Course $course): bool {
                $course->load(['quizzes' => fn ($query) => $query->where('status', 'active')->with('questions.answers')]);

                return $course->quizzes->contains(fn ($quiz) => $this->readiness->isReady($quiz));
            })
            ->values();
        $page = LengthAwarePaginator::resolveCurrentPage();
        $courses = new LengthAwarePaginator(
            $readyCourses->forPage($page, 10),
            $readyCourses->count(),
            10,
            $page,
            ['path' => request()->url()]
        );

        return view('student.courses.index', compact('courses'));
    }

    public function show(Course $course): View
    {
        abort_unless($course->status === 'active', 404);

        $course->load(['quizzes' => fn ($query) => $query->where('status', 'active')->with('questions.answers')->latest()]);
        $course->setRelation(
            'quizzes',
            $course->quizzes->filter(fn ($quiz) => $this->readiness->isReady($quiz))->values()
        );

        return view('student.courses.show', compact('course'));
    }
}
