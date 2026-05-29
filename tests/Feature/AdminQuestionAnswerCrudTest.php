<?php

namespace Tests\Feature;

use App\Models\Answer;
use App\Models\Course;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminQuestionAnswerCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_question_for_quiz(): void
    {
        $admin = User::factory()->admin()->create();
        $quiz = $this->quiz();

        $response = $this->actingAs($admin)->post('/admin/questions', [
            'quiz_id' => $quiz->id,
            'question_text' => 'What does MVC stand for?',
            'points' => 2,
        ]);

        $question = Question::where('question_text', 'What does MVC stand for?')->firstOrFail();

        $response->assertRedirect(route('admin.questions.show', $question, absolute: false));
        $this->assertDatabaseHas('questions', [
            'quiz_id' => $quiz->id,
            'question_text' => 'What does MVC stand for?',
            'points' => 2,
        ]);
    }

    public function test_admin_can_update_and_delete_question(): void
    {
        $admin = User::factory()->admin()->create();
        $quiz = $this->quiz();
        $question = Question::create([
            'quiz_id' => $quiz->id,
            'question_text' => 'Old question',
            'points' => 1,
        ]);

        $this->actingAs($admin)
            ->put("/admin/questions/{$question->id}", [
                'quiz_id' => $quiz->id,
                'question_text' => 'Updated question',
                'points' => 3,
            ])
            ->assertRedirect(route('admin.questions.show', $question, absolute: false));

        $this->assertDatabaseHas('questions', [
            'id' => $question->id,
            'question_text' => 'Updated question',
            'points' => 3,
        ]);

        $this->actingAs($admin)
            ->delete("/admin/questions/{$question->id}")
            ->assertRedirect(route('admin.questions.index', absolute: false));

        $this->assertDatabaseMissing('questions', [
            'id' => $question->id,
        ]);
    }

    public function test_admin_can_create_and_view_correct_answer(): void
    {
        $admin = User::factory()->admin()->create();
        $question = $this->question();

        $response = $this->actingAs($admin)->post('/admin/answers', [
            'question_id' => $question->id,
            'answer_text' => 'Model View Controller',
            'is_correct' => '1',
        ]);

        $response->assertRedirect(route('admin.questions.show', $question, absolute: false));
        $this->assertDatabaseHas('answers', [
            'question_id' => $question->id,
            'answer_text' => 'Model View Controller',
            'is_correct' => true,
        ]);

        $this->actingAs($admin)
            ->get("/admin/questions/{$question->id}")
            ->assertOk()
            ->assertSee('Model View Controller')
            ->assertSee('Yes');
    }

    public function test_question_must_keep_at_least_one_correct_answer_when_answers_exist(): void
    {
        $admin = User::factory()->admin()->create();
        $question = $this->question();

        $this->actingAs($admin)
            ->post('/admin/answers', [
                'question_id' => $question->id,
                'answer_text' => 'Incorrect first answer',
            ])
            ->assertSessionHasErrors('is_correct');

        $correctAnswer = Answer::create([
            'question_id' => $question->id,
            'answer_text' => 'Correct answer',
            'is_correct' => true,
        ]);

        $this->actingAs($admin)
            ->put("/admin/answers/{$correctAnswer->id}", [
                'question_id' => $question->id,
                'answer_text' => 'Correct answer',
                'is_correct' => '0',
            ])
            ->assertSessionHasErrors('is_correct');
    }

    public function test_admin_can_add_incorrect_answer_after_correct_answer_exists(): void
    {
        $admin = User::factory()->admin()->create();
        $question = $this->question();

        Answer::create([
            'question_id' => $question->id,
            'answer_text' => 'Correct answer',
            'is_correct' => true,
        ]);

        $this->actingAs($admin)
            ->post('/admin/answers', [
                'question_id' => $question->id,
                'answer_text' => 'Incorrect answer',
            ])
            ->assertRedirect(route('admin.questions.show', $question, absolute: false));

        $this->assertDatabaseHas('answers', [
            'question_id' => $question->id,
            'answer_text' => 'Incorrect answer',
            'is_correct' => false,
        ]);
    }

    public function test_student_cannot_access_question_management(): void
    {
        $student = User::factory()->student()->create();

        $this->actingAs($student)
            ->get('/admin/questions')
            ->assertForbidden();
    }

    private function quiz(): Quiz
    {
        $course = Course::create(['title' => 'Laravel Course']);

        return Quiz::create([
            'course_id' => $course->id,
            'title' => 'Laravel Quiz',
        ]);
    }

    private function question(): Question
    {
        return Question::create([
            'quiz_id' => $this->quiz()->id,
            'question_text' => 'What does MVC stand for?',
            'points' => 1,
        ]);
    }
}
