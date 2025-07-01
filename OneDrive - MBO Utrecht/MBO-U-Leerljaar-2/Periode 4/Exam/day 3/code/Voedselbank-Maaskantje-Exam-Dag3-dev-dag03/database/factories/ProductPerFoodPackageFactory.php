<?php

namespace Database\Factories;

use App\Models\FoodPackage;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductPerFoodPackageFactory extends Factory
{
    public function definition(): array
    {
        return [
            'food_package_id' => FoodPackage::factory(),
            'product_id' => Product::factory(),
            'quantity_units' => $this->faker->numberBetween(1, 10),
        ];
    }
}
