<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Property;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Faker\Factory as Faker;

class PropertySeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('en_US');
        
    
        $landlords = User::whereIn('id', range(17, 21))->get();
        
        if ($landlords->isEmpty()) {
            $this->command->error('No landlord users found. Please ensure users with IDs 7-11 exist.');
            return;
        }

     
        $locations = [
            'Abucay, Tacloban City',
            'V&G Subdivision, Tacloban City',
            'Sagkahan, Tacloban City',
            'Downtown, Tacloban City',
            'Marasbaras, Tacloban City',
            'Paterno St., Tacloban City',
            'Real Street, Tacloban City',
            'San Jose, Tacloban City',
            'Young Field, Tacloban City',
            'Independencia St., Tacloban City'
        ];
        $propertyTitles = [
            "Modern Studio Apartment in Prime Location",
            "Cozy Bedspace Near Universities",
            "Spacious Family Home with Garden",
            "Student-Friendly Room for Rent",
            "Newly Renovated Apartment Unit",
            "Furnished Room in Shared House",
            "Budget-Friendly Bedspace for Students",
            "Contemporary Apartment with City Views",
            "Comfortable Single Room with Utilities",
            "Family House with Parking Space"
        ];
       $propertyDescriptions = [
        "This well-maintained property offers comfortable living in a convenient location. Features include modern amenities, good ventilation, and a secure environment.",
        "Spacious and bright property with excellent facilities. Perfect for students or young professionals looking for a convenient place to stay.",
        "Located in a peaceful neighborhood, this property provides a comfortable living space with essential amenities and good security.",
        "Modern property with updated features and facilities. Situated in a prime location with easy access to public transportation and local amenities.",
        "Cozy and well-maintained property offering a comfortable living environment. Close to schools, markets, and public transportation."
    ];

        $propertyTypes = [
            'bedspace' => ['min' => 1500, 'max' => 3000],
            'room' => ['min' => 3000, 'max' => 8000],
            'apartment' => ['min' => 8000, 'max' => 15000],
            'house' => ['min' => 15000, 'max' => 30000],
        ];

    
        $availableForOptions = ['male', 'female', 'couples', 'any'];

        for ($i = 0; $i < 50; $i++) {
            try {
                DB::beginTransaction();

                $type = array_rand($propertyTypes);
                $rentRange = $propertyTypes[$type];

                
$property = Property::create([
    'user_id' => $landlords->random()->id,
    'title' => $faker->randomElement($propertyTitles) . ' in ' . $faker->randomElement($locations),
    'description' => $faker->randomElement($propertyDescriptions),
    'contact_number' => '09' . $faker->numerify('#########'),
    'monthly_rent' => $faker->numberBetween($rentRange['min'], $rentRange['max']),
    'type' => $type,
    'available_for' => $faker->randomElement($availableForOptions),
    'address' => $faker->randomElement($locations),
    'is_available' => $faker->boolean(85),
]);

                $imageCount = rand(1, 5);
                for ($j = 0; $j < $imageCount; $j++) {
                    $property->images()->create([
                        'image_path' => "property-images/sample-" . rand(1, 5) . ".jpg"
                    ]);
                }

                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                $this->command->error("Failed to create property: " . $e->getMessage());
            }
        }
    }
}