<?php


namespace Tests\Feature\Auth;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutExceptionHandling();
    }

    public function test_login_page_can_be_rendered(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
        $response->assertViewIs('auth.login');
    }

    public function test_users_can_login_with_valid_credentials(): void
    {
        $user = User::factory()->create([
            'email' => 'test@email.com',
            'password' => bcrypt('password123'),
            'first_name' => 'Nikko',
            'role' => 'tenant'
        ]);

        $response = $this->post('/login', [
            'email' => 'test@email.com',
            'password' => 'password123'
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('tenant.dashboard'));
        $response->assertSessionHas('success', "Welcome back, Nikko!");
    }

    public function test_users_cannot_login_with_invalid_credentials(): void
    {
        $user = User::factory()->create([
            'email' => 'test@email.com',
            'password' => bcrypt('password123')
        ]);

        $response = $this->post('/login', [
            'email' => 'test@email.com',
            'password' => 'wrong-password'
        ]);

        $this->assertGuest();
        $response->assertSessionHas('error', 'These credentials do not match our records.');
        $response->assertRedirect();
        $response->assertSessionHasInput('email');
    }

    public function test_users_cannot_login_kun_invalid_an_email(): void
    {
        $response = $this->post('/login', [
            'email' => 'nonexistent@example.com',
            'password' => 'password123'
        ]);

        $this->assertGuest();
        $response->assertSessionHas('error', 'These credentials do not match our records.');
        $response->assertRedirect();
    }
}