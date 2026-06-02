<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\QuizAttempt;
use App\Services\LearningProgressService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class QuizAttemptHistoryController extends Controller
{
    public function __construct(private readonly LearningProgressService $progress)
    {
    }

    public function index(Request $request): View
    {
        $attempts = $request->user()
            ->quizAttempts()
            ->with('quiz.course')
            ->latest('submitted_at')
            ->paginate(10);

        return view('student.attempts.index', [
            'attempts' => $attempts,
            'progress' => $this->progress->summaryForUser($request->user()),
        ]);
    }

    public function show(Request $request, QuizAttempt $attempt): View
    {
        abort_unless($attempt->user_id === $request->user()->id, 403);

        $attempt->load(['quiz.course', 'attemptAnswers.question', 'attemptAnswers.answer']);

        return view('student.attempts.show', [
            'attempt' => $attempt,
            'progress' => $this->progress->summaryForUser($request->user()),
        ]);
    }
}
