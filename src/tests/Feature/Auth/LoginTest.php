<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_form_can_be_rendered()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response->assertViewIs('auth.login');
    }

    public function test_users_can_login_with_valid_credentials()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password123'),
            'role' => 'tenant',
            'first_name' => 'Nikko'
        ]);

        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'password123'
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('tenant.dashboard'));
        $response->assertSessionHas('success', "Welcome back, Nikko!");
    }

    public function test_users_cannot_login_with_invalid_password()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password123')
        ]);

        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'wrongpassword'
        ]);

        $this->assertGuest();
        $response->assertSessionHas('error', 'These credentials do not match our records.');
    }

    public function test_users_cannot_login_with_invalid_email()
    {
        $response = $this->post('/login', [
            'email' => 'nonexistent@example.com',
            'password' => 'password123'
        ]);

        $this->assertGuest();
        $response->assertSessionHas('error');
    }

    public function test_users_cannot_login_with_empty_credentials()
    {
        $response = $this->post('/login', [
            'email' => '',
            'password' => ''
        ]);

        $response->assertSessionHasErrors(['email', 'password']);
        $this->assertGuest();
    }

    public function test_users_cannot_login_with_invalid_email_format()
    {
        $response = $this->post('/login', [
            'email' => 'invalid-email',
            'password' => 'password123'
        ]);

        $response->assertSessionHasErrors(['email']);
        $this->assertGuest();
    }

    public function test_different_roles_redirect_to_correct_dashboard()
    {
        $tenant = User::factory()->create([
            'role' => 'tenant',
            'email' => 'tenant@example.com',
            'password' => Hash::make('password123')
        ]);

        $landlord = User::factory()->create([
            'role' => 'landlord',
            'email' => 'landlord@example.com',
            'password' => Hash::make('password123')
        ]);

        $admin = User::factory()->create([
            'role' => 'admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password123')
        ]);

        $response = $this->post('/login', [
            'email' => 'tenant@example.com',
            'password' => 'password123'
        ]);
        $response->assertRedirect(route('tenant.dashboard'));

        $this->post('/logout');

        $response = $this->post('/login', [
            'email' => 'landlord@example.com',
            'password' => 'password123'
        ]);
        $response->assertRedirect(route('landlord.dashboard'));

        $this->post('/logout');

        $response = $this->post('/login', [
            'email' => 'admin@example.com',
            'password' => 'password123'
        ]);
        $response->assertRedirect(route('admin.dashboard'));
    }
}