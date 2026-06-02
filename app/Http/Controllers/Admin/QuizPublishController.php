<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Services\QuizReadinessService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;

class QuizPublishController extends Controller
{
    public function __construct(private readonly QuizReadinessService $readiness)
    {
    }

    public function publish(Quiz $quiz): RedirectResponse
    {
        $errors = $this->readiness->errors($quiz);

        if ($errors !== []) {
            throw ValidationException::withMessages([
                'publish' => $errors,
            ]);
        }

        $quiz->update(['status' => 'active']);

        return back()->with('success', 'Quiz published successfully.');
    }

    public function unpublish(Quiz $quiz): RedirectResponse
    {
        $quiz->update(['status' => 'inactive']);

        return back()->with('success', 'Quiz moved back to draft.');
    }
}
