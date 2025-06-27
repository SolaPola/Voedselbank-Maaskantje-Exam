<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Food_package>
 */
class Food_packageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'client_id' => $this->faker->numberBetween(1, 100), // Assuming you have clients with IDs from 1 to 100
            'soort_voedselpakket' => $this->faker->word,
            'gezinssamenstelling' => $this->faker->sentence,
            'issued_at' => $this->faker->dateTimeThisYear(),
            'comment' => $this->faker->sentence,
            'isactive' => $this->faker->boolean,
            'dateadded' => now(),
            'datechanged' => now(),
        ];
    }
}
