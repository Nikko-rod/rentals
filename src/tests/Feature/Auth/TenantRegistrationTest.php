<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class TenantRegistrationTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_registration_page_can_be_rendered()
    {
        $response = $this->get('/register/tenant');
        $response->assertStatus(200);
        $response->assertViewIs('auth.register-tenant');
    }

    public function test_new_tenant_can_register()
    {
        $userData = [
            'first_name' => 'Nikko',
            'last_name' => 'Villas',
            'email' => 'nikko@sample.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'contact_number' => '09123456789',
           
        ];

        $response = $this->post('/register/tenant', $userData);

        $this->assertDatabaseHas('users', [
            'first_name' => 'Nikko',
            'last_name' => 'Villas',
            'email' => 'nikko@sample.com',
            'contact_number' => '09123456789',
            'role' => 'tenant',
            'is_archived' => false,
    
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('verification.notice'));
    }

    public function test_tenant_cannot_register_with_existing_email()
    {
        User::factory()->create([
            'email' => 'existing@example.com'
        ]);

        $response = $this->post('/register/tenant', [
            'first_name' => 'Bianca',
            'last_name' => 'Oledan',
            'email' => 'existing@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'contact_number' => '09123456789',
         
        ]);

        $response->assertSessionHasErrors(['email']);
    }

    public function test_contact_number_must_be_valid_format()
    {
        $response = $this->post('/register/tenant', [
            'first_name' => 'Nikko',
            'last_name' => 'Villas',
            'email' => 'nikko@sample',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'contact_number' => '1234567', 
         
        ]);

        $response->assertSessionHasErrors(['contact_number']);
    }

    public function test_all_fields_are_required()
    {
        $response = $this->post('/register/tenant', []);

        $response->assertSessionHasErrors([
            'first_name',
            'last_name',
            'email',
            'password',
            'contact_number',

        ]);
    }

    public function test_password_must_be_confirmed()
    {
        $response = $this->post('/register/tenant', [
            'first_name' => 'Nikko',
            'last_name' => 'Villas',
            'email' => 'nikko@sample',
            'password' => 'password123',
            'password_confirmation' => 'different123',
            'contact_number' => '09123456789',
         
        ]);

        $response->assertSessionHasErrors(['password']);
    }

    public function test_password_must_be_minimum_eight_characters()
    {
        $response = $this->post('/register/tenant', [
            'first_name' => 'Nikko',
            'last_name' => 'Villas',
            'email' => 'nikko@sample',
            'password' => 'short',
            'password_confirmation' => 'short',
            'contact_number' => '09123456789',
         
        ]);

        $response->assertSessionHasErrors(['password']);
    }
}