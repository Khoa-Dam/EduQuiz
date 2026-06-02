<?php

namespace App\Services;

use App\Models\Quiz;

class QuizReadinessService
{
    /**
     * @return list<string>
     */
    public function errors(Quiz $quiz): array
    {
        $quiz->loadMissing('questions.answers');

        $errors = [];

        if ($quiz->questions->isEmpty()) {
            $errors[] = 'Add at least one question.';
        }

        foreach ($quiz->questions as $index => $question) {
            $label = 'Question '.($index + 1);

            if ($question->answers->count() < 2) {
                $errors[] = "{$label} needs at least two answers.";
            }

            if (! $question->answers->contains('is_correct', true)) {
                $errors[] = "{$label} needs at least one correct answer.";
            }
        }

        return $errors;
    }

    public function isReady(Quiz $quiz): bool
    {
        return $this->errors($quiz) === [];
    }
}
