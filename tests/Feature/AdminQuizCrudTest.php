<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\Quiz;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminQuizCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_quiz_list_with_related_course(): void
    {
        $admin = User::factory()->admin()->create();
        $course = Course::create(['title' => 'Laravel Course']);
        Quiz::create([
            'course_id' => $course->id,
            'title' => 'Laravel Quiz',
            'duration_minutes' => 20,
        ]);

        $this->actingAs($admin)
            ->get('/admin/quizzes')
            ->assertOk()
            ->assertSee('Quiz Management')
            ->assertSee('Laravel Quiz')
            ->assertSee('Laravel Course');
    }

    public function test_student_cannot_access_quiz_management(): void
    {
        $student = User::factory()->student()->create();

        $this->actingAs($student)
            ->get('/admin/quizzes')
            ->assertForbidden();
    }

    public function test_admin_can_create_quiz_for_course(): void
    {
        $admin = User::factory()->admin()->create();
        $course = Course::create(['title' => 'Laravel Course']);

        $response = $this->actingAs($admin)->post('/admin/quizzes', [
            'course_id' => $course->id,
            'title' => 'Laravel Quiz',
            'description' => 'Intro quiz.',
            'duration_minutes' => 15,
            'status' => 'active',
        ]);

        $quiz = Quiz::where('title', 'Laravel Quiz')->firstOrFail();

        $response->assertRedirect(route('admin.quizzes.show', $quiz, absolute: false));
        $this->assertDatabaseHas('quizzes', [
            'course_id' => $course->id,
            'title' => 'Laravel Quiz',
            'duration_minutes' => 15,
        ]);
    }

    public function test_quiz_requires_course_and_title(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->post('/admin/quizzes', [
                'course_id' => '',
                'title' => '',
                'status' => 'active',
            ])
            ->assertSessionHasErrors(['course_id', 'title']);
    }

    public function test_admin_can_update_quiz(): void
    {
        $admin = User::factory()->admin()->create();
        $course = Course::create(['title' => 'Original Course']);
        $newCourse = Course::create(['title' => 'Updated Course']);
        $quiz = Quiz::create([
            'course_id' => $course->id,
            'title' => 'Old Quiz',
            'duration_minutes' => 10,
            'status' => 'active',
        ]);

        $this->actingAs($admin)
            ->put("/admin/quizzes/{$quiz->id}", [
                'course_id' => $newCourse->id,
                'title' => 'Updated Quiz',
                'description' => 'Updated quiz description.',
                'duration_minutes' => 30,
                'status' => 'inactive',
            ])
            ->assertRedirect(route('admin.quizzes.show', $quiz, absolute: false));

        $this->assertDatabaseHas('quizzes', [
            'id' => $quiz->id,
            'course_id' => $newCourse->id,
            'title' => 'Updated Quiz',
            'duration_minutes' => 30,
            'status' => 'inactive',
        ]);
    }

    public function test_admin_can_delete_quiz(): void
    {
        $admin = User::factory()->admin()->create();
        $course = Course::create(['title' => 'Laravel Course']);
        $quiz = Quiz::create([
            'course_id' => $course->id,
            'title' => 'Quiz To Delete',
        ]);

        $this->actingAs($admin)
            ->delete("/admin/quizzes/{$quiz->id}")
            ->assertRedirect(route('admin.quizzes.index', absolute: false));

        $this->assertDatabaseMissing('quizzes', [
            'id' => $quiz->id,
        ]);
    }
}
