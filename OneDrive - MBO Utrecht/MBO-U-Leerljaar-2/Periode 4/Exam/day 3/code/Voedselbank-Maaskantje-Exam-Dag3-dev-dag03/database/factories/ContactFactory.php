<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ContactFactory extends Factory
{
    public function definition(): array
    {
        return [
            'street' => $this->faker->streetName(),
            'house_number' => $this->faker->buildingNumber(),
            'addition' => $this->faker->optional()->randomElement(['A', 'B', 'C']),
            'postal_code' => $this->faker->postcode(),
            'city' => $this->faker->city(),
            'email' => $this->faker->optional()->email(),
            'mobile' => $this->faker->optional()->phoneNumber(),
        ];
    }
}
