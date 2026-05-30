<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke(Request $request): RedirectResponse|View
    {
        if ($request->user()?->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        return view('dashboard', [
            'stats' => [
                'activeCourses' => Course::where('status', 'active')->count(),
                'activeQuizzes' => Quiz::where('status', 'active')->count(),
                'attempts' => QuizAttempt::where('user_id', $request->user()?->id)->count(),
            ],
            'featuredCourse' => Course::withCount(['quizzes' => fn ($query) => $query->where('status', 'active')])
                ->where('status', 'active')
                ->latest()
                ->first(),
            'latestAttempt' => QuizAttempt::with('quiz.course')
                ->where('user_id', $request->user()?->id)
                ->latest('submitted_at')
                ->first(),
        ]);
    }
}
