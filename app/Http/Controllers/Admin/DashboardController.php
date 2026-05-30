<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        return view('admin.dashboard', [
            'stats' => [
                'courses' => Course::count(),
                'quizzes' => Quiz::count(),
                'questions' => Question::count(),
                'attempts' => QuizAttempt::count(),
            ],
            'latestAttempts' => QuizAttempt::with(['user', 'quiz.course'])
                ->latest('submitted_at')
                ->limit(3)
                ->get(),
        ]);
    }
}
