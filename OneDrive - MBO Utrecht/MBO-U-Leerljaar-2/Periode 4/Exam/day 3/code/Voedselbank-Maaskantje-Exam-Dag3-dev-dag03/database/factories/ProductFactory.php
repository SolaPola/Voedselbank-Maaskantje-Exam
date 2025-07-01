<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        return [
            'category_id' => Category::factory(),
            'name' => $this->faker->words(2, true),
            'allergy_type' => $this->faker->optional()->randomElement(['Contains nuts', 'Contains dairy', 'Contains gluten']),
            'barcode' => $this->faker->optional()->ean13(),
            'expiry_date' => $this->faker->optional()->dateTimeBetween('now', '+2 years')->format('Y-m-d'),
            'description' => $this->faker->optional()->sentence(),
            'status' => $this->faker->randomElement(['Available', 'Expired', 'Reserved', 'Distributed']),
        ];
    }
}
