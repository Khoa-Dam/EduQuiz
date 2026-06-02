<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminCourseCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_course_list(): void
    {
        $admin = User::factory()->admin()->create();
        Course::create(['title' => 'Laravel Fundamentals']);

        $this->actingAs($admin)
            ->get('/admin/courses')
            ->assertOk()
            ->assertSee('Course Management')
            ->assertSee('Laravel Fundamentals');
    }

    public function test_student_cannot_access_course_management(): void
    {
        $student = User::factory()->student()->create();

        $this->actingAs($student)
            ->get('/admin/courses')
            ->assertForbidden();
    }

    public function test_admin_can_create_course(): void
    {
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->post('/admin/courses', [
            'title' => 'Laravel 101',
            'description' => 'Learn Laravel basics.',
            'status' => 'active',
        ]);

        $course = Course::where('title', 'Laravel 101')->firstOrFail();

        $response->assertRedirect(route('admin.courses.show', $course, absolute: false));
        $this->assertDatabaseHas('courses', [
            'title' => 'Laravel 101',
            'status' => 'active',
        ]);
    }

    public function test_course_title_is_required(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->post('/admin/courses', [
                'title' => '',
                'description' => 'Missing title.',
                'status' => 'active',
            ])
            ->assertSessionHasErrors('title');
    }

    public function test_admin_can_update_course(): void
    {
        $admin = User::factory()->admin()->create();
        $course = Course::create([
            'title' => 'Old Course',
            'description' => 'Old description.',
            'status' => 'active',
        ]);

        $this->actingAs($admin)
            ->put("/admin/courses/{$course->id}", [
                'title' => 'Updated Course',
                'description' => 'Updated description.',
                'status' => 'inactive',
            ])
            ->assertRedirect(route('admin.courses.show', $course, absolute: false));

        $this->assertDatabaseHas('courses', [
            'id' => $course->id,
            'title' => 'Updated Course',
            'status' => 'inactive',
        ]);
    }

    public function test_admin_can_delete_course(): void
    {
        $admin = User::factory()->admin()->create();
        $course = Course::create(['title' => 'Course To Delete']);

        $this->actingAs($admin)
            ->delete("/admin/courses/{$course->id}")
            ->assertRedirect(route('admin.courses.index', absolute: false));

        $this->assertDatabaseMissing('courses', [
            'id' => $course->id,
        ]);
    }
}
