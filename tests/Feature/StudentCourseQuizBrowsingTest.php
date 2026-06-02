<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\Answer;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class StudentCourseQuizBrowsingTest extends TestCase
{
    use RefreshDatabase;

    public function test_student_sees_only_active_courses(): void
    {
        $student = User::factory()->student()->create();
        $activeCourse = Course::create(['title' => 'Active Course', 'status' => 'active']);
        $this->readyQuiz($activeCourse, 'Ready Quiz');
        Course::create(['title' => 'Inactive Course', 'status' => 'inactive']);

        $this->actingAs($student)
            ->get('/courses')
            ->assertOk()
            ->assertSee('Active Course')
            ->assertDontSee('Inactive Course');
    }

    public function test_student_course_list_hides_courses_without_ready_quizzes(): void
    {
        $student = User::factory()->student()->create();
        Course::create(['title' => 'Empty Active Course', 'status' => 'active']);
        $readyCourse = Course::create(['title' => 'Ready Active Course', 'status' => 'active']);
        $this->readyQuiz($readyCourse, 'Ready Quiz');

        $this->actingAs($student)
            ->get('/courses')
            ->assertOk()
            ->assertSee('Ready Active Course')
            ->assertDontSee('Empty Active Course');
    }

    public function test_student_sees_active_quizzes_on_course_detail(): void
    {
        $student = User::factory()->student()->create();
        $course = Course::create(['title' => 'Active Course', 'status' => 'active']);
        $this->readyQuiz($course, 'Active Quiz');
        Quiz::create(['course_id' => $course->id, 'title' => 'Inactive Quiz', 'status' => 'inactive']);

        $this->actingAs($student)
            ->get("/courses/{$course->id}")
            ->assertOk()
            ->assertSee('Active Quiz')
            ->assertDontSee('Inactive Quiz');
    }

    public function test_student_can_view_quiz_detail_and_start_page(): void
    {
        $student = User::factory()->student()->create();
        $course = Course::create(['title' => 'Active Course', 'status' => 'active']);
        $quiz = Quiz::create([
            'course_id' => $course->id,
            'title' => 'Active Quiz',
            'status' => 'active',
            'duration_minutes' => 10,
        ]);
        $question = Question::create([
            'quiz_id' => $quiz->id,
            'question_text' => 'Sample question',
            'points' => 1,
        ]);
        Answer::create(['question_id' => $question->id, 'answer_text' => 'Correct', 'is_correct' => true]);
        Answer::create(['question_id' => $question->id, 'answer_text' => 'Wrong', 'is_correct' => false]);

        $this->actingAs($student)
            ->get("/quizzes/{$quiz->id}")
            ->assertOk()
            ->assertSee('Active Quiz')
            ->assertSee('Start Quiz');

        $this->actingAs($student)
            ->get("/quizzes/{$quiz->id}/start")
            ->assertOk()
            ->assertSee('This quiz has 1 questions');
    }

    public function test_student_pages_render_quiz_and_question_images(): void
    {
        Storage::fake('public');

        $student = User::factory()->student()->create();
        $course = Course::create(['title' => 'Active Course', 'status' => 'active']);
        Storage::disk('public')->put('quizzes/cover.jpg', 'fake image content');
        Storage::disk('public')->put('questions/question.jpg', 'fake image content');
        $quiz = Quiz::create([
            'course_id' => $course->id,
            'title' => 'Visual Quiz',
            'status' => 'active',
            'cover_image_path' => 'quizzes/cover.jpg',
        ]);
        $question = Question::create([
            'quiz_id' => $quiz->id,
            'question_text' => 'Visual question',
            'image_path' => 'questions/question.jpg',
            'points' => 1,
        ]);
        Answer::create(['question_id' => $question->id, 'answer_text' => 'Correct', 'is_correct' => true]);
        Answer::create(['question_id' => $question->id, 'answer_text' => 'Wrong', 'is_correct' => false]);

        $this->actingAs($student)
            ->get("/courses/{$course->id}")
            ->assertOk()
            ->assertSee('/storage/quizzes/cover.jpg');

        $this->actingAs($student)
            ->get("/quizzes/{$quiz->id}")
            ->assertOk()
            ->assertSee('/storage/quizzes/cover.jpg');

        $this->actingAs($student)
            ->get("/quizzes/{$quiz->id}/start")
            ->assertOk()
            ->assertSee('/storage/quizzes/cover.jpg')
            ->assertSee('/storage/questions/question.jpg');
    }

    public function test_inactive_course_or_quiz_is_not_visible_to_student(): void
    {
        $student = User::factory()->student()->create();
        $inactiveCourse = Course::create(['title' => 'Inactive Course', 'status' => 'inactive']);
        $activeCourse = Course::create(['title' => 'Active Course', 'status' => 'active']);
        $inactiveQuiz = Quiz::create([
            'course_id' => $activeCourse->id,
            'title' => 'Inactive Quiz',
            'status' => 'inactive',
        ]);

        $this->actingAs($student)
            ->get("/courses/{$inactiveCourse->id}")
            ->assertNotFound();

        $this->actingAs($student)
            ->get("/quizzes/{$inactiveQuiz->id}")
            ->assertNotFound();
    }

    public function test_student_still_cannot_access_admin_pages(): void
    {
        $student = User::factory()->student()->create();

        $this->actingAs($student)
            ->get('/admin/dashboard')
            ->assertForbidden();
    }

    public function test_incomplete_active_quiz_is_not_visible_to_student(): void
    {
        $student = User::factory()->student()->create();
        $course = Course::create(['title' => 'Active Course', 'status' => 'active']);
        $quiz = Quiz::create([
            'course_id' => $course->id,
            'title' => 'Incomplete Quiz',
            'status' => 'active',
        ]);

        $this->actingAs($student)
            ->get("/courses/{$course->id}")
            ->assertOk()
            ->assertDontSee('Incomplete Quiz');

        $this->actingAs($student)
            ->get("/quizzes/{$quiz->id}")
            ->assertNotFound();
    }

    private function readyQuiz(Course $course, string $title): Quiz
    {
        $quiz = Quiz::create([
            'course_id' => $course->id,
            'title' => $title,
            'status' => 'active',
        ]);
        $question = Question::create([
            'quiz_id' => $quiz->id,
            'question_text' => "{$title} question",
            'points' => 1,
        ]);
        Answer::create(['question_id' => $question->id, 'answer_text' => 'Correct', 'is_correct' => true]);
        Answer::create(['question_id' => $question->id, 'answer_text' => 'Wrong', 'is_correct' => false]);

        return $quiz;
    }
}
