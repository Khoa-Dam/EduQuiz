<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\QuizAttempt;
use Illuminate\Http\Request;
use Illuminate\View\View;

class QuizAttemptHistoryController extends Controller
{
    public function index(Request $request): View
    {
        $attempts = $request->user()
            ->quizAttempts()
            ->with('quiz.course')
            ->latest('submitted_at')
            ->paginate(10);

        return view('student.attempts.index', compact('attempts'));
    }

    public function show(Request $request, QuizAttempt $attempt): View
    {
        abort_unless($attempt->user_id === $request->user()->id, 403);

        $attempt->load(['quiz.course', 'attemptAnswers.question', 'attemptAnswers.answer']);

        return view('student.attempts.show', compact('attempt'));
    }
}
