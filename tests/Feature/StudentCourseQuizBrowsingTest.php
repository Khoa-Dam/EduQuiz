<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StudentCourseQuizBrowsingTest extends TestCase
{
    use RefreshDatabase;

    public function test_student_sees_only_active_courses(): void
    {
        $student = User::factory()->student()->create();
        Course::create(['title' => 'Active Course', 'status' => 'active']);
        Course::create(['title' => 'Inactive Course', 'status' => 'inactive']);

        $this->actingAs($student)
            ->get('/courses')
            ->assertOk()
            ->assertSee('Active Course')
            ->assertDontSee('Inactive Course');
    }

    public function test_student_sees_active_quizzes_on_course_detail(): void
    {
        $student = User::factory()->student()->create();
        $course = Course::create(['title' => 'Active Course', 'status' => 'active']);
        Quiz::create(['course_id' => $course->id, 'title' => 'Active Quiz', 'status' => 'active']);
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
        Question::create([
            'quiz_id' => $quiz->id,
            'question_text' => 'Sample question',
            'points' => 1,
        ]);

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
}
