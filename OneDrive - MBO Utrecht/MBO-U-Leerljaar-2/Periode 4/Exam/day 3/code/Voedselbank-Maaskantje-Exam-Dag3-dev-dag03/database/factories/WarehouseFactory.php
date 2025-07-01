<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class WarehouseFactory extends Factory
{
    public function definition(): array
    {
        return [
            'date_received' => $this->faker->optional()->date(),
            'date_delivered' => $this->faker->optional()->date(),
            'packaging_unit' => $this->faker->randomElement(['kg', 'pieces', 'liters', 'boxes', 'cans']),
            'quantity' => $this->faker->numberBetween(1, 1000),
        ];
    }
}
