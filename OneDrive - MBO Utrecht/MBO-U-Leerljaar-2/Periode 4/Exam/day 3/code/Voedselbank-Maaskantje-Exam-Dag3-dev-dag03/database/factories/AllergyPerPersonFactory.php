<?php

namespace Database\Factories;

use App\Models\Person;
use App\Models\Allergy;
use Illuminate\Database\Eloquent\Factories\Factory;

class AllergyPerPersonFactory extends Factory
{
    public function definition(): array
    {
        return [
            'person_id' => Person::factory(),
            'allergy_id' => Allergy::factory(),
        ];
    }
}
