<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use Illuminate\View\View;

class QuizController extends Controller
{
    public function show(Quiz $quiz): View
    {
        $this->ensureQuizIsAvailable($quiz);
        $quiz->load(['course', 'questions.answers']);

        return view('student.quizzes.show', compact('quiz'));
    }

    public function start(Quiz $quiz): View
    {
        $this->ensureQuizIsAvailable($quiz);
        $quiz->load(['course', 'questions.answers']);

        return view('student.quizzes.start', compact('quiz'));
    }

    private function ensureQuizIsAvailable(Quiz $quiz): void
    {
        $quiz->loadMissing('course');

        abort_unless($quiz->status === 'active' && $quiz->course->status === 'active', 404);
    }
}
