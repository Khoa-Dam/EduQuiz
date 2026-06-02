<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\Quiz;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Testing\File;
use Illuminate\Support\Facades\Storage;
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
            'status' => 'inactive',
        ]);

        $quiz = Quiz::where('title', 'Laravel Quiz')->firstOrFail();

        $response->assertRedirect(route('admin.quizzes.show', $quiz, absolute: false));
        $this->assertDatabaseHas('quizzes', [
            'course_id' => $course->id,
            'title' => 'Laravel Quiz',
            'duration_minutes' => 15,
        ]);
    }

    public function test_admin_can_upload_quiz_cover_image(): void
    {
        Storage::fake('public');

        $admin = User::factory()->admin()->create();
        $course = Course::create(['title' => 'Laravel Course']);

        $this->actingAs($admin)->post('/admin/quizzes', [
            'course_id' => $course->id,
            'title' => 'Laravel Quiz',
            'description' => 'Intro quiz.',
            'cover_image' => $this->fakePng('quiz-cover.png'),
            'duration_minutes' => 15,
            'status' => 'inactive',
        ])->assertRedirect();

        $quiz = Quiz::where('title', 'Laravel Quiz')->firstOrFail();

        $this->assertNotNull($quiz->cover_image_path);
        Storage::disk('public')->assertExists($quiz->cover_image_path);
        $this->assertStringContainsString('/storage/', $quiz->coverImageUrl());
    }

    public function test_admin_can_replace_and_remove_quiz_cover_image(): void
    {
        Storage::fake('public');

        $admin = User::factory()->admin()->create();
        $course = Course::create(['title' => 'Laravel Course']);
        $oldPath = $this->fakePng('old-cover.png')->store('quizzes', 'public');
        $quiz = Quiz::create([
            'course_id' => $course->id,
            'title' => 'Old Quiz',
            'cover_image_path' => $oldPath,
            'status' => 'inactive',
        ]);

        $this->actingAs($admin)
            ->put("/admin/quizzes/{$quiz->id}", [
                'course_id' => $course->id,
                'title' => 'Updated Quiz',
                'description' => 'Updated quiz description.',
                'cover_image' => $this->fakePng('new-cover.png'),
                'duration_minutes' => 30,
                'status' => 'inactive',
            ])
            ->assertRedirect(route('admin.quizzes.show', $quiz, absolute: false));

        $quiz->refresh();
        Storage::disk('public')->assertMissing($oldPath);
        Storage::disk('public')->assertExists($quiz->cover_image_path);

        $pathToRemove = $quiz->cover_image_path;

        $this->actingAs($admin)
            ->put("/admin/quizzes/{$quiz->id}", [
                'course_id' => $course->id,
                'title' => 'Updated Quiz',
                'description' => 'Updated quiz description.',
                'remove_cover_image' => '1',
                'duration_minutes' => 30,
                'status' => 'inactive',
            ])
            ->assertRedirect(route('admin.quizzes.show', $quiz, absolute: false));

        $this->assertNull($quiz->refresh()->cover_image_path);
        Storage::disk('public')->assertMissing($pathToRemove);
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

    public function test_legacy_quiz_form_cannot_publish_incomplete_quiz(): void
    {
        $admin = User::factory()->admin()->create();
        $course = Course::create(['title' => 'Laravel Course']);
        $quiz = Quiz::create([
            'course_id' => $course->id,
            'title' => 'Draft Quiz',
            'status' => 'inactive',
        ]);

        $this->actingAs($admin)
            ->put("/admin/quizzes/{$quiz->id}", [
                'course_id' => $course->id,
                'title' => 'Draft Quiz',
                'description' => 'Still missing questions.',
                'duration_minutes' => 15,
                'status' => 'active',
            ])
            ->assertSessionHasErrors('status');

        $this->assertDatabaseHas('quizzes', [
            'id' => $quiz->id,
            'status' => 'inactive',
        ]);
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
            'status' => 'inactive',
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

    private function fakePng(string $name): File
    {
        return File::createWithContent(
            $name,
            base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP8/x8AAwMCAO+/p9sAAAAASUVORK5CYII=')
        );
    }
}
