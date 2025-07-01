<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SupplierFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->company(),
            'contact_person' => $this->faker->optional()->name(),
            'supplier_number' => $this->faker->unique()->regexify('SUP[0-9]{6}'),
            'supplier_type' => $this->faker->randomElement(['Supermarket', 'Wholesaler', 'Restaurant', 'Bakery', 'Farm']),
        ];
    }
}
