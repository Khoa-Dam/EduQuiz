<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use App\Services\QuizReadinessService;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    public function __construct(private readonly QuizReadinessService $readiness)
    {
    }

    public function __invoke(): View
    {
        $quizzes = Quiz::with('questions.answers')->get();
        $readyQuizzes = $quizzes->filter(fn (Quiz $quiz): bool => $this->readiness->isReady($quiz))->count();

        return view('admin.dashboard', [
            'stats' => [
                'courses' => Course::count(),
                'quizzes' => Quiz::count(),
                'questions' => Question::count(),
                'attempts' => QuizAttempt::count(),
            ],
            'launchStats' => [
                'ready' => $readyQuizzes,
                'needsFixes' => max(0, $quizzes->count() - $readyQuizzes),
            ],
            'latestAttempts' => QuizAttempt::with(['user', 'quiz.course'])
                ->latest('submitted_at')
                ->limit(3)
                ->get(),
        ]);
    }
}
