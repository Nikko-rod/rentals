<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class LandlordRegistrationTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');
    }

    public function test_registration_page_can_be_rendered()
    {
        $response = $this->get('/register/landlord');
        $response->assertStatus(200);
        $response->assertViewIs('auth.register-landlord');
    }

                public function test_new_landlord_can_register()
        {
            $businessPermit = UploadedFile::fake()->create('permit.pdf', 1024);
            
            $userData = [
                'first_name' => 'Nikko',
                'last_name' => 'Villas',
                'email' => 'nikko@example.com',
                'password' => 'password123',
                'password_confirmation' => 'password123',
                'contact_number' => '09123456789',
                'business_permit' => $businessPermit
            ];
        
            $response = $this->post('/register/landlord', $userData);
        
            $user = User::where('email', 'nikko@example.com')->first();
            $this->assertNotNull($user, 'User was not created');
            
            $this->assertDatabaseHas('users', [
                'first_name' => 'Nikko',
                'last_name' => 'Villas',
                'email' => 'nikko@example.com',
                'contact_number' => '09123456789',
                'role' => 'landlord',
                'is_archived' => false
            ]);
        
            $this->assertDatabaseHas('landlords', [
                'user_id' => $user->id,
                'approval_status' => 'pending',
                'rejection_remark' => null
            ]);
        
            Storage::disk('public')->assertExists('permits/' . $businessPermit->hashName());
        
            $this->assertAuthenticated();
            $response->assertRedirect(route('verification.notice'));
        }

    public function test_landlord_cannot_register_with_existing_email()
    {
        User::factory()->create([
            'email' => 'existing@example.com'
        ]);

        $response = $this->post('/register/landlord', [
            'first_name' => 'Bia',
            'last_name' => 'Oledan',
            'email' => 'existing@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'contact_number' => '09123456789',
            'business_permit' => UploadedFile::fake()->create('permit.pdf', 1024)
        ]);

        $response->assertSessionHasErrors(['email']);
    }

    public function test_business_permit_must_be_pdf()
    {
        $response = $this->post('/register/landlord', [
            'first_name' => 'Nikko',
            'last_name' => 'Villas',
            'email' => 'nikko@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'contact_number' => '09123456789',
            'business_permit' => UploadedFile::fake()->create('permit.jpg', 1024)
        ]);

        $response->assertSessionHasErrors(['business_permit']);
    }

    public function test_all_fields_are_required()
    {
        $response = $this->post('/register/landlord', []);

        $response->assertSessionHasErrors([
            'first_name',
            'last_name',
            'email',
            'password',
            'contact_number',
            'business_permit'
        ]);
    }

    public function test_contact_number_must_be_valid_format()
    {
        $response = $this->post('/register/landlord', [
            'first_name' => 'Nikko',
            'last_name' => 'Villas',
            'email' => 'nikko@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'contact_number' => '1234567',
            'business_permit' => UploadedFile::fake()->create('permit.pdf', 1024)
        ]);

        $response->assertSessionHasErrors(['contact_number']);
    }

    public function test_password_must_be_confirmed()
    {
        $response = $this->post('/register/landlord', [
            'first_name' => 'Nikko',
            'last_name' => 'Villas',
            'email' => 'nikko@example.com',
            'password' => 'password123',
            'password_confirmation' => 'different123',
            'contact_number' => '09123456789',
            'business_permit' => UploadedFile::fake()->create('permit.pdf', 1024)
        ]);

        $response->assertSessionHasErrors(['password']);
    }

    public function test_password_must_be_minimum_eight_characters()
    {
        $response = $this->post('/register/landlord', [
            'first_name' => 'Nikko',
            'last_name' => 'Villas',
            'email' => 'nikko@example.com',
            'password' => 'short',
            'password_confirmation' => 'short',
            'contact_number' => '09123456789',
            'business_permit' => UploadedFile::fake()->create('permit.pdf', 1024)
        ]);

        $response->assertSessionHasErrors(['password']);
    }
}