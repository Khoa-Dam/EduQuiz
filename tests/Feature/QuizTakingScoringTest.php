<?php

namespace Tests\Feature;

use App\Models\Answer;
use App\Models\Course;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class QuizTakingScoringTest extends TestCase
{
    use RefreshDatabase;

    public function test_student_can_submit_quiz_and_score_is_saved(): void
    {
        $student = User::factory()->student()->create();
        [$quiz, $questionOne, $questionTwo, $correctOne, $wrongTwo] = $this->quizWithQuestions();

        $response = $this->actingAs($student)
            ->post("/quizzes/{$quiz->id}/submit", [
                'answers' => [
                    $questionOne->id => $correctOne->id,
                    $questionTwo->id => $wrongTwo->id,
                ],
            ]);

        $this->assertDatabaseHas('quiz_attempts', [
            'user_id' => $student->id,
            'quiz_id' => $quiz->id,
            'score' => 2,
            'total_questions' => 2,
            'correct_answers' => 1,
        ]);

        $attempt = $student->quizAttempts()->where('quiz_id', $quiz->id)->firstOrFail();
        $response->assertRedirect(route('attempts.show', $attempt, absolute: false));

        $this->assertDatabaseHas('quiz_attempt_answers', [
            'question_id' => $questionOne->id,
            'answer_id' => $correctOne->id,
            'is_correct' => true,
        ]);

        $this->assertDatabaseHas('quiz_attempt_answers', [
            'question_id' => $questionTwo->id,
            'answer_id' => $wrongTwo->id,
            'is_correct' => false,
        ]);
    }

    public function test_submit_requires_an_answer_for_each_question(): void
    {
        $student = User::factory()->student()->create();
        [$quiz, $questionOne] = $this->quizWithQuestions();

        $this->actingAs($student)
            ->post("/quizzes/{$quiz->id}/submit", [
                'answers' => [
                    $questionOne->id => '',
                ],
            ])
            ->assertSessionHasErrors(["answers.{$questionOne->id}"]);
    }

    public function test_submit_rejects_answer_that_does_not_belong_to_question(): void
    {
        $student = User::factory()->student()->create();
        [$quiz, $questionOne, $questionTwo, $correctOne] = $this->quizWithQuestions();

        $this->actingAs($student)
            ->post("/quizzes/{$quiz->id}/submit", [
                'answers' => [
                    $questionOne->id => $correctOne->id,
                    $questionTwo->id => $correctOne->id,
                ],
            ])
            ->assertSessionHasErrors(["answers.{$questionTwo->id}"]);
    }

    public function test_inactive_quiz_cannot_be_submitted(): void
    {
        $student = User::factory()->student()->create();
        [$quiz, $questionOne, , $correctOne] = $this->quizWithQuestions();
        $quiz->update(['status' => 'inactive']);

        $this->actingAs($student)
            ->post("/quizzes/{$quiz->id}/submit", [
                'answers' => [
                    $questionOne->id => $correctOne->id,
                ],
            ])
            ->assertNotFound();
    }

    private function quizWithQuestions(): array
    {
        $course = Course::create(['title' => 'Laravel Course', 'status' => 'active']);
        $quiz = Quiz::create([
            'course_id' => $course->id,
            'title' => 'Laravel Quiz',
            'status' => 'active',
        ]);

        $questionOne = Question::create([
            'quiz_id' => $quiz->id,
            'question_text' => 'Question one',
            'points' => 2,
        ]);
        $questionTwo = Question::create([
            'quiz_id' => $quiz->id,
            'question_text' => 'Question two',
            'points' => 3,
        ]);

        $correctOne = Answer::create([
            'question_id' => $questionOne->id,
            'answer_text' => 'Correct one',
            'is_correct' => true,
        ]);
        Answer::create([
            'question_id' => $questionOne->id,
            'answer_text' => 'Wrong one',
            'is_correct' => false,
        ]);
        Answer::create([
            'question_id' => $questionTwo->id,
            'answer_text' => 'Correct two',
            'is_correct' => true,
        ]);
        $wrongTwo = Answer::create([
            'question_id' => $questionTwo->id,
            'answer_text' => 'Wrong two',
            'is_correct' => false,
        ]);

        return [$quiz, $questionOne, $questionTwo, $correctOne, $wrongTwo];
    }
}
