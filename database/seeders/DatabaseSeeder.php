<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Supplier;
use App\Models\Product;
use App\Models\Client;
use App\Models\FoodPackage;
use App\Models\PackageItem;
use App\Models\Delivery;
use App\Models\Contact;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@voedselbankmaaskantje.nl',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // Create Warehouse Worker
        User::create([
            'name' => 'Jan de Magazijnmedewerker',
            'email' => 'magazijn@voedselbankmaaskantje.nl',
            'password' => Hash::make('password'),
            'role' => 'warehouse_worker',
            'email_verified_at' => now(),
        ]);

        // Create Volunteer
        User::create([
            'name' => 'Maria Vrijwilliger',
            'email' => 'vrijwilliger@voedselbankmaaskantje.nl',
            'password' => Hash::make('password'),
            'role' => 'volunteer',
            'email_verified_at' => now(),
        ]);

      
        // Seed Suppliers
        Supplier::create([
            'name' => 'Albert Heijn Distributie',
            'address' => 'Provincialeweg 11, 1506 MA Zaandam',
            'contact_name' => 'Jan Janssen',
            'contact_email' => 'jan.janssen@ah.nl',
            'phone' => '075-6591000',
            'next_delivery' => now()->addDays(7),
            'comment' => 'Hoofdleverancier voor verse producten',
            'isactive' => true,
        ]);

        Supplier::create([
            'name' => 'Jumbo Foodservice',
            'address' => 'Industrieweg 1, 5466 AE Veghel',
            'contact_name' => 'Piet Pietersen',
            'contact_email' => 'p.pietersen@jumbo.com',
            'phone' => '0413-366000',
            'next_delivery' => now()->addDays(5),
            'comment' => 'Leverancier van houdbare producten',
            'isactive' => true,
        ]);

        



// Seed Categories
$category1 = Category::create([
    'name' => 'Brood',
    'comment' => 'Alle soorten brood',
    'isactive' => true,
]);
$category2 = Category::create([
    'name' => 'Fruit',
    'comment' => 'Vers fruit',
    'isactive' => true,
]);
        $category3 = Category::create([
            'name' => 'Zuivel',
            'comment' => 'Melk en zuivelproducten',
            'isactive' => true,
            ]);

// Seed Products
        Product::create([
            'name' => 'Wit Brood',
            'categoriesid' => $category1->id,
            'ean_code' => '8710398501301',
            'stock' => 50,
            'expiry_date' => now()->addDays(3),
            'comment' => 'Vers wit brood',
            'isactive' => true,
            ]);

        Product::create([
            'name' => 'Rijst 1kg',
            'categoriesid' => $category1->id,
            'ean_code' => '8712566321456',
            'stock' => 100,
            'expiry_date' => now()->addMonths(12),
            'comment' => 'Basmati rijst',
            'isactive' => true,
            ]);

        Product::create([
            'name' => 'Bananen',
            'categoriesid' => $category2->id,
            'ean_code' => '8712345678901',
            'stock' => 25,
            'expiry_date' => now()->addDays(5),
            'comment' => 'Verse bananen',
            'isactive' => true,
            ]);

        Product::create([
            'name' => 'Melk 1L',
            'categoriesid' => $category3->id,
            'ean_code' => '8712345678902',
            'stock' => 40,
            'expiry_date' => now()->addDays(7),
            'comment' => 'Volle melk',
            'isactive' => true,
            ]);


        // Seed Clients
        Client::create([
            'name' => 'Familie de Vries',
            'address' => 'Kerkstraat 15, 5231 BC Den Bosch',
            'postal_code' => '5231 BC',
            'phone' => '073-1234567',
            'email' => 'devries@email.com',
            'adults' => 2,
            'children' => 2,
            'babies' => 0,
            'comment' => 'Gezin met 2 kinderen',
            'isactive' => true,
        ]);

        Client::create([
            'name' => 'Mevrouw Jansen',
            'address' => 'Dorpsstraat 8, 5232 AB Den Bosch',
            'postal_code' => '5232 AB',
            'phone' => '073-2345678',
            'email' => 'jansen@email.com',
            'adults' => 1,
            'children' => 0,
            'babies' => 0,
            'comment' => 'Alleenstaande senior',
            'isactive' => true,
        ]);

        Client::create([
            'name' => 'Familie Bakker',
            'address' => 'Marktplein 23, 5233 CD Den Bosch',
            'postal_code' => '5233 CD',
            'phone' => '073-3456789',
            'email' => 'bakker@email.com',
            'adults' => 2,
            'children' => 1,
            'babies' => 1,
            'comment' => 'Jong gezin met baby',
            'isactive' => true,
        ]);

        // Seed Food Packages
        $foodPackage1 = FoodPackage::create([
            'client_id' => 1,
            'issued_at' => now(),
            'comment' => 'Wekelijks pakket voor gezin',
            'isactive' => true,
        ]);

        $foodPackage2 = FoodPackage::create([
            'client_id' => 2,
            'issued_at' => now()->subDays(1),
            'comment' => 'Basispakket voor 1 persoon',
            'isactive' => true,
        ]);

        // Seed Package Items
        PackageItem::create([
            'food_package_id' => $foodPackage1->id,
            'product_id' => 1,
            'product_name' => 'Wit Brood',
            'amount' => 2,
            'comment' => '2 broden voor gezin',
            'isactive' => true,
        ]);

        PackageItem::create([
            'food_package_id' => $foodPackage1->id,
            'product_id' => 2,
            'product_name' => 'Rijst 1kg',
            'amount' => 1,
            'comment' => '1 pak rijst',
            'isactive' => true,
        ]);

        PackageItem::create([
            'food_package_id' => $foodPackage2->id,
            'product_id' => 3,
            'product_name' => 'Bananen',
            'amount' => 1,
            'comment' => '1 tros bananen',
            'isactive' => true,
        ]);

        // Seed Deliveries
        Delivery::create([
            'supplier_name' => 'Albert Heijn Distributie',
            'supplier_id' => 1,
            'product_id' => 1,
            'amount' => 100,
            'delivery_date' => now()->subDays(2),
            'comment' => 'Leveringsbon #12345',
            'isactive' => true,
        ]);

        Delivery::create([
            'supplier_name' => 'Jumbo Foodservice',
            'supplier_id' => 2,
            'product_id' => 2,
            'amount' => 50,
            'delivery_date' => now()->subDays(1),
            'comment' => 'Leveringsbon #67890',
            'isactive' => true,
        ]);

        // Seed Contacts
        Contact::create([
            'name' => 'Gemeente Den Bosch',
            'email' => 'info@denbosch.nl',
            'phone' => '073-156156',
            'comment' => 'Contactpersoon voor subsidies',
            'isactive' => true,
        ]);

        Contact::create([
            'name' => 'Voedselbank Nederland',
            'email' => 'info@voedselbankennederland.nl',
            'phone' => '030-2440440',
            'comment' => 'Landelijke organisatie',
            'isactive' => true,
        ]);

        Contact::create([
            'name' => 'Lokale Supermarkt',
            'email' => 'manager@lokalesupermarkt.nl',
            'phone' => '073-7890123',
            'comment' => 'Donateur van overschotten',
            'isactive' => true,
        ]);
    }
}
