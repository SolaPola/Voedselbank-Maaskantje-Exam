<?php

namespace Database\Factories;

use App\Models\Family;
use Illuminate\Database\Eloquent\Factories\Factory;

class FoodPackageFactory extends Factory
{
    public function definition(): array
    {
        return [
            'family_id' => Family::factory(),
            'package_number' => $this->faker->unique()->regexify('PKG[0-9]{8}'),
            'date_composed' => $this->faker->optional()->date(),
            'date_issued' => $this->faker->optional()->date(),
            'status' => $this->faker->randomElement(['Composed', 'Ready', 'Issued', 'Cancelled']),
        ];
    }
}
