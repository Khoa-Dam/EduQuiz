<?php

namespace Tests\Feature;

use App\Models\Answer;
use App\Models\Course;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAttemptReviewTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_all_attempts(): void
    {
        $admin = User::factory()->admin()->create();
        $student = User::factory()->student()->create(['name' => 'Student One']);
        $attempt = $this->attemptFor($student);

        $this->actingAs($admin)
            ->get('/admin/attempts')
            ->assertOk()
            ->assertSee('Student One')
            ->assertSee($attempt->quiz->title);
    }

    public function test_admin_can_view_attempt_detail(): void
    {
        $admin = User::factory()->admin()->create();
        $student = User::factory()->student()->create();
        $attempt = $this->attemptFor($student);

        $this->actingAs($admin)
            ->get("/admin/attempts/{$attempt->id}")
            ->assertOk()
            ->assertSee('Attempt Detail')
            ->assertSee($student->email)
            ->assertSee('Correct answer');
    }

    public function test_student_cannot_access_admin_attempt_review(): void
    {
        $student = User::factory()->student()->create();

        $this->actingAs($student)
            ->get('/admin/attempts')
            ->assertForbidden();
    }

    private function attemptFor(User $user): QuizAttempt
    {
        $course = Course::create(['title' => 'Laravel Course']);
        $quiz = Quiz::create(['course_id' => $course->id, 'title' => 'Laravel Quiz']);
        $question = Question::create([
            'quiz_id' => $quiz->id,
            'question_text' => 'Question text',
            'points' => 1,
        ]);
        $answer = Answer::create([
            'question_id' => $question->id,
            'answer_text' => 'Correct answer',
            'is_correct' => true,
        ]);
        $attempt = QuizAttempt::create([
            'user_id' => $user->id,
            'quiz_id' => $quiz->id,
            'score' => 1,
            'total_questions' => 1,
            'correct_answers' => 1,
            'started_at' => now(),
            'submitted_at' => now(),
        ]);
        $attempt->attemptAnswers()->create([
            'question_id' => $question->id,
            'answer_id' => $answer->id,
            'is_correct' => true,
        ]);

        return $attempt->load('quiz.course');
    }
}
