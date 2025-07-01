<?php

namespace Database\Factories;

use App\Models\Supplier;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductPerSupplierFactory extends Factory
{
    public function definition(): array
    {
        return [
            'supplier_id' => Supplier::factory(),
            'product_id' => Product::factory(),
            'date_delivered' => $this->faker->optional()->date(),
            'next_delivery_date' => $this->faker->optional()->dateTimeBetween('now', '+1 month')->format('Y-m-d'),
        ];
    }
}
