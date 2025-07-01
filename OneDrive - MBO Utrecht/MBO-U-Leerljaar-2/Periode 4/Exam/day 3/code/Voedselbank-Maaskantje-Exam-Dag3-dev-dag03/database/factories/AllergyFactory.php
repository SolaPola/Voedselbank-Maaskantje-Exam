<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AllergyFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->randomElement(['Peanuts', 'Tree Nuts', 'Dairy', 'Eggs', 'Soy', 'Wheat', 'Fish', 'Shellfish', 'Sesame']),
            'description' => $this->faker->sentence(),
            'anaphylactic_risk' => $this->faker->boolean(30),
        ];
    }
}
