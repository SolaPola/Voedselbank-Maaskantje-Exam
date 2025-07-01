<?php

namespace Database\Factories;

use App\Models\Family;
use App\Models\DietPreference;
use Illuminate\Database\Eloquent\Factories\Factory;

class DietPreferencePerFamilyFactory extends Factory
{
    public function definition(): array
    {
        return [
            'family_id' => Family::factory(),
            'diet_preference_id' => DietPreference::factory(),
        ];
    }
}
