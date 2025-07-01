<?php

namespace Database\Factories;

use App\Models\Supplier;
use App\Models\Contact;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContactPerSupplierFactory extends Factory
{
    public function definition(): array
    {
        return [
            'supplier_id' => Supplier::factory(),
            'contact_id' => Contact::factory(),
        ];
    }
}
