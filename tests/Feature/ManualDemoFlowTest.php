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

class ManualDemoFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_manual_demo_flow_passes_end_to_end(): void
    {
        $admin = User::factory()->admin()->create([
            'email' => 'admin-flow@example.com',
            'name' => 'Manual Admin',
        ]);

        $this->post('/register', [
            'name' => 'Manual Student',
            'email' => 'manual-student@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ])->assertRedirect(route('dashboard', absolute: false));

        $student = User::where('email', 'manual-student@example.com')->firstOrFail();
        $this->assertAuthenticatedAs($student);

        $this->post('/logout')->assertRedirect('/');
        $this->assertGuest();

        $this->post('/login', [
            'email' => $student->email,
            'password' => 'password',
        ])->assertRedirect(route('dashboard', absolute: false));

        $this->assertAuthenticatedAs($student);

        $this->get('/dashboard')
            ->assertOk()
            ->assertSee('Student Dashboard');

        $this->get('/admin/dashboard')->assertForbidden();

        $this->post('/logout')->assertRedirect('/');
        $this->assertGuest();

        $this->post('/login', [
            'email' => $admin->email,
            'password' => 'password',
        ])->assertRedirect(route('dashboard', absolute: false));

        $this->assertAuthenticatedAs($admin);

        $this->get('/admin/dashboard')
            ->assertOk()
            ->assertSee('Admin Dashboard');

        $this->post('/admin/courses', [
            'title' => 'Manual Demo Course',
            'description' => 'Course created during manual flow coverage.',
            'status' => 'active',
        ])->assertRedirect();

        $course = Course::where('title', 'Manual Demo Course')->firstOrFail();

        $this->post('/admin/quizzes', [
            'course_id' => $course->id,
            'title' => 'Manual Demo Quiz',
            'description' => 'Quiz created during manual flow coverage.',
            'duration_minutes' => 15,
            'status' => 'active',
        ])->assertRedirect();

        $quiz = Quiz::where('title', 'Manual Demo Quiz')->firstOrFail();

        $this->post('/admin/questions', [
            'quiz_id' => $quiz->id,
            'question_text' => 'Which framework is EduQuiz built with?',
            'points' => 2,
        ])->assertRedirect();

        $question = Question::where('question_text', 'Which framework is EduQuiz built with?')->firstOrFail();

        $this->post('/admin/answers', [
            'question_id' => $question->id,
            'answer_text' => 'Laravel',
            'is_correct' => '1',
        ])->assertRedirect(route('admin.questions.show', $question, absolute: false));

        $correctAnswer = Answer::where('answer_text', 'Laravel')->firstOrFail();

        $this->post('/admin/answers', [
            'question_id' => $question->id,
            'answer_text' => 'Django',
        ])->assertRedirect(route('admin.questions.show', $question, absolute: false));

        $this->assertDatabaseHas('answers', [
            'question_id' => $question->id,
            'answer_text' => 'Django',
            'is_correct' => false,
        ]);

        $this->post('/logout')->assertRedirect('/');
        $this->assertGuest();

        $this->post('/login', [
            'email' => $student->email,
            'password' => 'password',
        ])->assertRedirect(route('dashboard', absolute: false));

        $this->get('/courses')
            ->assertOk()
            ->assertSee('Manual Demo Course');

        $this->get("/courses/{$course->id}")
            ->assertOk()
            ->assertSee('Manual Demo Quiz');

        $this->get("/quizzes/{$quiz->id}/start")
            ->assertOk()
            ->assertSee('Which framework is EduQuiz built with?')
            ->assertSee('Laravel')
            ->assertSee('Django');

        $submitResponse = $this->post("/quizzes/{$quiz->id}/submit", [
            'answers' => [
                $question->id => $correctAnswer->id,
            ],
        ]);

        $attempt = QuizAttempt::where('user_id', $student->id)
            ->where('quiz_id', $quiz->id)
            ->firstOrFail();

        $submitResponse->assertRedirect(route('attempts.show', $attempt, absolute: false));

        $this->assertDatabaseHas('quiz_attempts', [
            'id' => $attempt->id,
            'user_id' => $student->id,
            'quiz_id' => $quiz->id,
            'score' => 2,
            'total_questions' => 1,
            'correct_answers' => 1,
        ]);

        $this->get('/my-attempts')
            ->assertOk()
            ->assertSee('Manual Demo Quiz');

        $this->get("/my-attempts/{$attempt->id}")
            ->assertOk()
            ->assertSee('Attempt Result')
            ->assertSee('Laravel')
            ->assertSee('Correct');

        $this->post('/logout')->assertRedirect('/');
        $this->assertGuest();

        $this->post('/login', [
            'email' => $admin->email,
            'password' => 'password',
        ])->assertRedirect(route('dashboard', absolute: false));

        $this->get('/admin/attempts')
            ->assertOk()
            ->assertSee('Manual Student')
            ->assertSee('Manual Demo Quiz');

        $this->get("/admin/attempts/{$attempt->id}")
            ->assertOk()
            ->assertSee('Attempt Detail')
            ->assertSee($student->email)
            ->assertSee('Laravel');

        $this->post('/logout')->assertRedirect('/');
        $this->assertGuest();
    }
}
