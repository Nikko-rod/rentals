<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Property;
use Illuminate\Database\Eloquent\Factories\Factory;

class PropertyFactory extends Factory
{
    protected $model = Property::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'title' => fake()->sentence(),
            'description' => fake()->paragraph(),
            'address' => fake()->address(),
            'contact_number' => '09' . fake()->numerify('#########'),
            'available_for' => fake()->randomElement(['male', 'female', 'couples', 'any']),
            'type' => fake()->randomElement(['bedspace', 'house', 'room', 'apartment']),
            'monthly_rent' => fake()->randomFloat(2, 1000, 50000),
            'is_available' => true,
        ];
    }
}