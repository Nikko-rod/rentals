<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Property;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PropertyTest extends TestCase
{
    use RefreshDatabase;

    private User $landlord;

    protected function setUp(): void
    {
        parent::setUp();
        $this->landlord = User::factory()->create(['role' => 'landlord']);
        $this->actingAs($this->landlord);
    }

    public function test_landlord_can_view_properties_list(): void
    {
        Property::factory(3)->create(['user_id' => $this->landlord->id]);

        $response = $this->get(route('landlord.properties.index'));

        $response->assertStatus(200);
        $response->assertViewIs('landlord.properties.index');
        $response->assertViewHas('properties');
    }

    public function test_landlord_can_create_property(): void
    {
        Storage::fake('public');

        $response = $this->post(route('landlord.properties.store'), [
            'title' => 'Test Property',
            'description' => 'Test Description',
            'address' => '123 Test Street',
            'contact_number' => '09123456789',
            'available_for' => 'any',
            'type' => 'apartment',
            'monthly_rent' => 15000,
            'images' => [
                UploadedFile::fake()->image('property1.jpg'),
                UploadedFile::fake()->image('property2.jpg'),
            ]
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('properties', [
            'title' => 'Test Property',
            'user_id' => $this->landlord->id
        ]);
        $this->assertDatabaseCount('property_images', 2);
    }

    public function test_landlord_can_update_property(): void
    {
        $property = Property::factory()->create([
            'user_id' => $this->landlord->id
        ]);

        $response = $this->put(route('landlord.properties.update', $property), [
            'title' => 'Updated Title',
            'description' => 'Updated Description',
            'address' => '456 Updated Street',
            'contact_number' => '09987654321',
            'available_for' => 'male',
            'type' => 'room',
            'monthly_rent' => 20000,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('properties', [
            'id' => $property->id,
            'title' => 'Updated Title'
        ]);
    }

    public function test_landlord_can_delete_property(): void
    {
        $property = Property::factory()->create([
            'user_id' => $this->landlord->id
        ]);

        $response = $this->delete(route('landlord.properties.destroy', $property));

        $response->assertRedirect();
        $this->assertDatabaseMissing('properties', ['id' => $property->id]);
    }

    public function test_landlord_cannot_modify_others_property(): void
    {
        $otherLandlord = User::factory()->create(['role' => 'landlord']);
        $property = Property::factory()->create([
            'user_id' => $otherLandlord->id
        ]);

        $response = $this->put(route('landlord.properties.update', $property), [
            'title' => 'Hacked Property'
        ]);

        $response->assertForbidden();
    }

    public function test_property_requires_validation(): void
    {
        $response = $this->post(route('landlord.properties.store'), []);

        $response->assertSessionHasErrors([
            'title', 'description', 'address', 
            'contact_number', 'available_for', 
            'type', 'monthly_rent'
        ]);
    }

    public function test_landlord_can_delete_property_image(): void
    {
        Storage::fake('public');
        
        $property = Property::factory()->create([
            'user_id' => $this->landlord->id
        ]);

        $image = $property->images()->create([
            'image_path' => UploadedFile::fake()->image('test.jpg')->store('properties', 'public')
        ]);

        $response = $this->delete(route('landlord.properties.deleteImage', $image));

        $response->assertRedirect();
        $this->assertDatabaseMissing('property_images', ['id' => $image->id]);
        Storage::disk('public')->assertMissing($image->image_path);
    }
}