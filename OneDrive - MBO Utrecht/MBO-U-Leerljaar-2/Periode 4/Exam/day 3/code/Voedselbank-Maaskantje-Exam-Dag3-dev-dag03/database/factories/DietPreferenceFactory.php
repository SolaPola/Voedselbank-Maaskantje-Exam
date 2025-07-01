<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class DietPreferenceFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->randomElement(['Vegetarian', 'Vegan', 'Halal', 'Kosher', 'Gluten-Free', 'Diabetic', 'Low-Sodium']),
            'description' => $this->faker->sentence(),
        ];
    }
}
