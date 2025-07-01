<?php

namespace Database\Factories;

use App\Models\Family;
use App\Models\Contact;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContactPerFamilyFactory extends Factory
{
    public function definition(): array
    {
        return [
            'family_id' => Family::factory(),
            'contact_id' => Contact::factory(),
        ];
    }
}
