<?php

namespace Database\Factories;

use App\Models\Family;
use Illuminate\Database\Eloquent\Factories\Factory;

class PersonFactory extends Factory
{
    public function definition(): array
    {
        return [
            'family_id' => Family::factory(),
            'first_name' => $this->faker->firstName(),
            'infix' => $this->faker->optional()->randomElement(['de', 'van', 'van der', 'van den']),
            'last_name' => $this->faker->lastName(),
            'date_of_birth' => $this->faker->date(),
            'person_type' => $this->faker->randomElement(['Adult', 'Child', 'Baby']),
            'is_representative' => $this->faker->boolean(20),
        ];
    }
}
