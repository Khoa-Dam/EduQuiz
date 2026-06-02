<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\QuizAttempt;
use Illuminate\View\View;

class AttemptController extends Controller
{
    public function index(): View
    {
        $attempts = QuizAttempt::query()
            ->with(['user', 'quiz.course'])
            ->latest('submitted_at')
            ->paginate(15);

        return view('admin.attempts.index', compact('attempts'));
    }

    public function show(QuizAttempt $attempt): View
    {
        $attempt->load(['user', 'quiz.course', 'attemptAnswers.question', 'attemptAnswers.answer']);

        return view('admin.attempts.show', compact('attempt'));
    }
}
