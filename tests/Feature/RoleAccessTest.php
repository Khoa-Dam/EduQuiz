<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoleAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_registered_users_default_to_student_role(): void
    {
        $response = $this->post('/register', [
            'name' => 'Student User',
            'email' => 'student-role@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertRedirect(route('dashboard', absolute: false));

        $this->assertDatabaseHas('users', [
            'email' => 'student-role@example.com',
            'role' => User::ROLE_STUDENT,
        ]);
    }

    public function test_student_sees_student_dashboard(): void
    {
        $student = User::factory()->student()->create();

        $this->actingAs($student)
            ->get('/dashboard')
            ->assertOk()
            ->assertSee('Student Dashboard');
    }

    public function test_admin_is_redirected_to_admin_dashboard(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->get('/dashboard')
            ->assertRedirect(route('admin.dashboard', absolute: false));

        $this->actingAs($admin)
            ->get('/admin/dashboard')
            ->assertOk()
            ->assertSee('Admin Dashboard');
    }

    public function test_student_cannot_access_admin_dashboard(): void
    {
        $student = User::factory()->student()->create();

        $this->actingAs($student)
            ->get('/admin/dashboard')
            ->assertForbidden();
    }
}
