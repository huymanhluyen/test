<?php

namespace Tests\Feature\Http\Controllers\Admin;

use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class AdminControllerTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_user_create_renders_a_submittable_form(): void
    {
        $response = $this->get('/admin/create');

        $response->assertSee('action="'.route('admin.store').'"', false)
            ->assertSee('name="password_confirmation"', false);
    }

    public function test_admin_create_still_renders_the_form(): void
    {
        $response = $this->get('/admin/create');

        $response->assertOk();
    }

    public function test_creating_a_user_returns_to_the_form_with_success(): void
    {
        $response = $this->post('/admin/store', [
            'name' => 'Test User',
            'email' => 'new-user@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect('/admin')
            ->assertSessionHas('success', 'User created successfully.');
        $this->assertDatabaseHas('users', ['email' => 'new-user@example.com', 'name' => 'Test User']);
    }

    public function test_mismatched_password_confirmation_shows_an_error_without_creating_a_user(): void
    {
        $response = $this->from('/admin/create')->post('/admin/store', [
            'name' => 'Test User',
            'email' => 'new-user@example.com',
            'password' => 'password123',
            'password_confirmation' => 'different-password',
        ]);

        $response->assertRedirect('/admin/create')
            ->assertSessionHasErrors(['password' => 'The password field confirmation does not match.']);
        $this->assertDatabaseMissing('users', ['email' => 'new-user@example.com']);
    }
}
