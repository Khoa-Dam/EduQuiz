<?php

namespace Tests\Feature;

use App\Models\Answer;
use App\Models\Course;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class StudentAttemptHistoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_student_can_view_own_attempt_history(): void
    {
        $student = User::factory()->student()->create();
        $attempt = $this->attemptFor($student);

        $this->actingAs($student)
            ->get('/my-attempts')
            ->assertOk()
            ->assertSee($attempt->quiz->title)
            ->assertSee('+90')
            ->assertSee('View result');
    }

    public function test_student_can_view_own_attempt_detail(): void
    {
        $student = User::factory()->student()->create();
        $attempt = $this->attemptFor($student);

        $this->actingAs($student)
            ->get("/my-attempts/{$attempt->id}")
            ->assertOk()
            ->assertSee('Attempt Result')
            ->assertSee('XP earned')
            ->assertSee('+90')
            ->assertSee('Correct answer')
            ->assertSee('Correct');
    }

    public function test_student_attempt_detail_renders_quiz_and_question_images(): void
    {
        Storage::fake('public');

        $student = User::factory()->student()->create();
        Storage::disk('public')->put('quizzes/result-cover.jpg', 'fake image content');
        Storage::disk('public')->put('questions/result-question.jpg', 'fake image content');
        $attempt = $this->attemptFor($student, 'quizzes/result-cover.jpg', 'questions/result-question.jpg');

        $this->actingAs($student)
            ->get('/my-attempts')
            ->assertOk()
            ->assertSee('/storage/quizzes/result-cover.jpg');

        $this->actingAs($student)
            ->get("/my-attempts/{$attempt->id}")
            ->assertOk()
            ->assertSee('/storage/quizzes/result-cover.jpg')
            ->assertSee('/storage/questions/result-question.jpg');
    }

    public function test_student_cannot_view_another_users_attempt(): void
    {
        $student = User::factory()->student()->create();
        $otherStudent = User::factory()->student()->create();
        $attempt = $this->attemptFor($otherStudent);

        $this->actingAs($student)
            ->get("/my-attempts/{$attempt->id}")
            ->assertForbidden();
    }

    private function attemptFor(User $user, ?string $quizCoverPath = null, ?string $questionImagePath = null): QuizAttempt
    {
        $course = Course::create(['title' => 'Laravel Course']);
        $quiz = Quiz::create([
            'course_id' => $course->id,
            'title' => 'Laravel Quiz',
            'cover_image_path' => $quizCoverPath,
        ]);
        $question = Question::create([
            'quiz_id' => $quiz->id,
            'question_text' => 'Question text',
            'image_path' => $questionImagePath,
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
            'xp_earned' => 90,
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
