<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $products = [
            'Brood wit', 'Brood bruin', 'Melk', 'Kaas', 'Boter', 'Eieren',
            'Appels', 'Bananen', 'Aardappelen', 'Wortelen', 'Uien',
            'Rijst', 'Pasta', 'Bonen in blik', 'Tomaten in blik'
        ];
        
        return [
            'name' => $this->faker->randomElement($products),
            'categoriesid' => Category::inRandomOrder()->first()?->id ?? 1,
            'ean_code' => $this->faker->ean13(),
            'stock' => $this->faker->numberBetween(0, 50),
            'expiry_date' => $this->faker->dateTimeBetween('now', '+30 days'),
            'comment' => $this->faker->optional()->sentence(),
            'isactive' => true,
            'dateadded' => now(),
            'datechanged' => now(),

        ];
    }
}
