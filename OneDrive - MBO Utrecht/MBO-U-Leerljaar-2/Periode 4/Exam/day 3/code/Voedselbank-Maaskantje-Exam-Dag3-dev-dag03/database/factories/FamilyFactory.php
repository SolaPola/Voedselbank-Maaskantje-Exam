<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class FamilyFactory extends Factory
{
    public function definition(): array
    {
        $adults = $this->faker->numberBetween(1, 4);
        $children = $this->faker->numberBetween(0, 6);
        $babies = $this->faker->numberBetween(0, 2);

        return [
            'name' => $this->faker->lastName() . ' Family',
            'code' => $this->faker->unique()->regexify('[A-Z]{3}[0-9]{3}'),
            'description' => $this->faker->optional()->sentence(),
            'number_of_adults' => $adults,
            'number_of_children' => $children,
            'number_of_babies' => $babies,
            'total_number_of_people' => $adults + $children + $babies,
        ];
    }
}
