<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Client>
 */
class ClientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'address' => fake()->address(),
            'postal_code' => fake()->postcode(),
            'phone' => fake()->randomNumber(9, true),
            'email' => fake()->unique()->safeEmail(),
            'preference' => fake()->randomElement(['Vegetarisch', 'Veganistisch', 'Halal', 'Glutenvrij', null]),
            'adults' => fake()->numberBetween(1, 4),
            'children' => fake()->numberBetween(0, 5),
            'babies' => fake()->numberBetween(0, 2),
            'comment' => fake()->optional()->sentence(),
            'isactive' => true,
        ];
    }
}
