<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Warehouse;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductPerWarehouseFactory extends Factory
{
    public function definition(): array
    {
        return [
            'product_id' => Product::factory(),
            'warehouse_id' => Warehouse::factory(),
            'location' => $this->faker->optional()->regexify('[A-Z][0-9]{2}-[0-9]{2}'),
        ];
    }
}
