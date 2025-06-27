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

        // Seed Categories
        Category::create([
            'name' => 'Granen & Brood',
            'comment' => 'Brood, rijst, pasta, granen',
            'isactive' => true,
        ]);

        Category::create([
            'name' => 'Groenten & Fruit',
            'comment' => 'Verse en ingeblkte groenten en fruit',
            'isactive' => true,
        ]);

        Category::create([
            'name' => 'Zuivel',
            'comment' => 'Melk, kaas, yoghurt',
            'isactive' => true,
        ]);

        Category::create([
            'name' => 'Vlees & Vis',
            'comment' => 'Vlees, vis, kip',
            'isactive' => true,
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

        // Seed Products
        Product::create([
            'name' => 'Wit Brood',
            'categoryid' => 1,
            'ean_code' => '8710398501301',
            'category' => 'Granen & Brood',
            'stock' => 50,
            'expiry_date' => now()->addDays(3),
            'comment' => 'Vers wit brood',
            'isactive' => true,
        ]);

        Product::create([
            'name' => 'Rijst 1kg',
            'categoryid' => 1,
            'ean_code' => '8712566321456',
            'category' => 'Granen & Brood',
            'stock' => 100,
            'expiry_date' => now()->addMonths(12),
            'comment' => 'Basmati rijst',
            'isactive' => true,
        ]);

        Product::create([
            'name' => 'Bananen',
            'categoryid' => 2,
            'ean_code' => '8712345678901',
            'category' => 'Groenten & Fruit',
            'stock' => 25,
            'expiry_date' => now()->addDays(5),
            'comment' => 'Verse bananen',
            'isactive' => true,
        ]);

        Product::create([
            'name' => 'Melk 1L',
            'categoryid' => 3,
            'ean_code' => '8712345678902',
            'category' => 'Zuivel',
            'stock' => 40,
            'expiry_date' => now()->addDays(7),
            'comment' => 'Volle melk',
            'isactive' => true,
        ]);

        // Seed Clients - Multiple dummy clients (expanded to 50+ clients)
        Client::create([
            'name' => 'Familie de Vries',
            'address' => 'Kerkstraat 15, 5231 BC Den Bosch',
            'postal_code' => '5231 BC',
            'phone' => '073-1234567',
            'email' => 'devries@email.com',
            'preference' => 'Glutenvrij',
            'adults' => 2,
            'children' => 2,
            'babies' => 0,
            'comment' => 'Gezin met 2 kinderen, glutenallergie',
            'isactive' => true,
        ]);

        Client::create([
            'name' => 'Mevrouw Jansen',
            'address' => 'Dorpsstraat 8, 5232 AB Den Bosch',
            'postal_code' => '5232 AB',
            'phone' => '073-2345678',
            'email' => 'jansen@email.com',
            'preference' => 'Vegetarisch',
            'adults' => 1,
            'children' => 0,
            'babies' => 0,
            'comment' => 'Alleenstaande senior, vegetarisch',
            'isactive' => true,
        ]);

        Client::create([
            'name' => 'Familie Bakker',
            'address' => 'Marktplein 23, 5233 CD Den Bosch',
            'postal_code' => '5233 CD',
            'phone' => '073-3456789',
            'email' => 'bakker@email.com',
            'preference' => 'Halal',
            'adults' => 2,
            'children' => 1,
            'babies' => 1,
            'comment' => 'Jong gezin met baby, halal voeding',
            'isactive' => true,
        ]);

        Client::create([
            'name' => 'Meneer van der Berg',
            'address' => 'Schoolstraat 45, 5234 EF Den Bosch',
            'postal_code' => '5234 EF',
            'phone' => '073-4567890',
            'email' => 'vandenberg@email.com',
            'preference' => null,
            'adults' => 1,
            'children' => 3,
            'babies' => 0,
            'comment' => 'Alleenstaande vader met 3 kinderen',
            'isactive' => true,
        ]);

        Client::create([
            'name' => 'Familie Hassan',
            'address' => 'Nieuwstraat 12, 5235 GH Den Bosch',
            'postal_code' => '5235 GH',
            'phone' => '073-5678901',
            'email' => 'hassan@email.com',
            'preference' => 'Halal',
            'adults' => 3,
            'children' => 4,
            'babies' => 1,
            'comment' => 'Groot gezin, halal voeding vereist',
            'isactive' => true,
        ]);

        Client::create([
            'name' => 'Mevrouw Pietersen',
            'address' => 'Bosstraat 67, 5236 IJ Den Bosch',
            'postal_code' => '5236 IJ',
            'phone' => '073-6789012',
            'email' => 'pietersen@email.com',
            'preference' => 'Lactosevrij',
            'adults' => 1,
            'children' => 0,
            'babies' => 0,
            'comment' => 'Senior met lactose-intolerantie',
            'isactive' => true,
        ]);

        Client::create([
            'name' => 'Familie Rodriguez',
            'address' => 'Waterstraat 89, 5237 KL Den Bosch',
            'postal_code' => '5237 KL',
            'phone' => '073-7890123',
            'email' => 'rodriguez@email.com',
            'preference' => null,
            'adults' => 2,
            'children' => 1,
            'babies' => 0,
            'comment' => 'Gezin met 1 kind, geen speciale wensen',
            'isactive' => true,
        ]);

        Client::create([
            'name' => 'Meneer Smit',
            'address' => 'Parkstraat 34, 5238 MN Den Bosch',
            'postal_code' => '5238 MN',
            'phone' => '073-8901234',
            'email' => 'smit@email.com',
            'preference' => 'Diabetisch',
            'adults' => 1,
            'children' => 0,
            'babies' => 0,
            'comment' => 'Diabetische voeding nodig',
            'isactive' => true,
        ]);

        Client::create([
            'name' => 'Familie Kowalski',
            'address' => 'Beatrixstraat 56, 5239 OP Den Bosch',
            'postal_code' => '5239 OP',
            'phone' => '073-9012345',
            'email' => 'kowalski@email.com',
            'preference' => null,
            'adults' => 2,
            'children' => 2,
            'babies' => 2,
            'comment' => 'Gezin met tweelingen, veel babyvoeding nodig',
            'isactive' => true,
        ]);

        Client::create([
            'name' => 'Mevrouw de Wit',
            'address' => 'Rozenlaan 78, 5240 QR Den Bosch',
            'postal_code' => '5240 QR',
            'phone' => '073-0123456',
            'email' => 'dewit@email.com',
            'preference' => 'Veganistisch',
            'adults' => 1,
            'children' => 1,
            'babies' => 0,
            'comment' => 'Alleenstaande moeder, veganistisch',
            'isactive' => true,
        ]);

        // 40+ clients seeder 
        $additionalClients = [
            ['Familie van den Berg', 'Lange Putstraat 10', '5211 KW', '073-1111111', 'vandenberg2@email.com', null, 2, 3, 0, 'Groot gezin'],
            ['Mevrouw Willems', 'Sint Jansstraat 25', '5211 DA', '073-2222222', 'willems@email.com', 'Vegetarisch', 1, 0, 0, 'Senior dame'],
            ['Familie Janssen', 'Hinthamerstraat 42', '5211 MV', '073-3333333', 'janssen@email.com', 'Halal', 2, 2, 1, 'Jong gezin'],
            ['Meneer Peters', 'Korte Putstraat 8', '5211 KP', '073-4444444', 'peters@email.com', null, 1, 1, 0, 'Alleenstaande vader'],
            ['Familie Dekker', 'Verwersstraat 15', '5211 HT', '073-5555555', 'dekker@email.com', 'Lactosevrij', 2, 2, 0, 'Beide ouders werkzoekend'],
            ['Mevrouw Mulder', 'Postelstraat 33', '5211 EA', '073-6666666', 'mulder@email.com', 'Diabetisch', 1, 0, 0, 'Diabetespatiënt'],
            ['Familie Ahmed', 'Kerkstraat 88', '5211 DZ', '073-7777777', 'ahmed@email.com', 'Halal', 3, 4, 2, 'Grote familie'],
            ['Meneer Visser', 'Magistratenlaan 7', '5223 MA', '073-8888888', 'visser@email.com', null, 1, 2, 0, 'Gescheiden vader'],
            ['Familie Chen', 'Orthenseweg 45', '5213 HH', '073-9999999', 'chen@email.com', null, 2, 1, 0, 'Nieuw in Nederland'],
            ['Mevrouw de Jong', 'Vughterstraat 120', '5211 GM', '073-1010101', 'dejong@email.com', 'Veganistisch', 1, 0, 0, 'Gepensioneerde'],
            ['Familie Pol', 'Citadellaan 22', '5211 XA', '073-1212121', 'pol@email.com', null, 2, 3, 0, 'Vader ziek'],
            ['Meneer Groot', 'Wolvenstraat 9', '5211 HH', '073-1313131', 'groot@email.com', null, 1, 0, 0, 'Senior meneer'],
            ['Familie Brouwer', 'Snelliusstraat 56', '5223 CB', '073-1414141', 'brouwer@email.com', 'Glutenvrij', 2, 1, 1, 'Baby met allergie'],
            ['Mevrouw Schouten', 'Bethaniestraat 11', '5211 HG', '073-1515151', 'schouten@email.com', null, 1, 2, 0, 'Alleenstaande moeder'],
            ['Familie Driessen', 'Graafseweg 234', '5213 AS', '073-1616161', 'driessen@email.com', 'Halal', 2, 2, 0, 'Moslimgezin'],
            ['Meneer Koning', 'Napoleonstraat 67', '5212 AE', '073-1717171', 'koning@email.com', 'Diabetisch', 1, 1, 0, 'Type 2 diabetes'],
            ['Familie Hofman', 'Wilhelminastraat 89', '5212 BH', '073-1818181', 'hofman@email.com', null, 2, 4, 0, 'Vier kinderen'],
            ['Mevrouw Boer', 'Hamstraat 34', '5211 TX', '073-1919191', 'boer@email.com', 'Lactosevrij', 1, 0, 0, 'Lactose-intolerant'],
            ['Familie Leeuwen', 'Eerste Sweelinckstraat 12', '5223 GE', '073-2020202', 'leeuwen@email.com', null, 2, 1, 1, 'Pasgeboren baby'],
            ['Meneer Verhoeven', 'Aartshertogenlaan 78', '5212 CP', '073-2121212', 'verhoeven@email.com', null, 1, 3, 0, 'Vader van drieling'],
            ['Familie Mohamed', 'Pater van den Elsenstraat 23', '5224 VS', '073-2222223', 'mohamed@email.com', 'Halal', 4, 3, 1, 'Zeer grote familie'],
            ['Mevrouw Hendriks', 'Dommelstraat 45', '5213 VT', '073-2323232', 'hendriks@email.com', 'Vegetarisch', 1, 1, 0, 'Single moeder'],
            ['Familie Claassen', 'Monseigneur Bekkersstraat 67', '5223 BG', '073-2424242', 'claassen@email.com', null, 2, 2, 0, 'Beide werkloos'],
            ['Meneer Kuiper', 'Margrietstraat 89', '5214 AB', '073-2525252', 'kuiper@email.com', null, 1, 0, 0, 'Oudere meneer'],
            ['Familie Singh', 'Tulpstraat 101', '5214 CD', '073-2626262', 'singh@email.com', 'Vegetarisch', 3, 2, 0, 'Sikh familie'],
            ['Mevrouw Rutten', 'Rozenstraat 23', '5214 EF', '073-2727272', 'rutten@email.com', null, 1, 1, 0, 'Weduwe'],
            ['Familie Berg', 'Lilystraat 45', '5214 GH', '073-2828282', 'berg@email.com', 'Glutenvrij', 2, 3, 1, 'Kind met coeliakie'],
            ['Meneer Wit', 'Jasmijnstraat 67', '5214 IJ', '073-2929292', 'wit@email.com', null, 1, 2, 0, 'Gescheiden vader'],
            ['Familie Zwart', 'Narcissenstraat 89', '5214 KL', '073-3030303', 'zwart@email.com', 'Veganistisch', 2, 1, 0, 'Vegan lifestyle'],
            ['Mevrouw Groen', 'Hyacintstraat 12', '5214 MN', '073-3131313', 'groen@email.com', 'Lactosevrij', 1, 0, 0, 'Lactose problemen'],
            ['Familie Blauw', 'Irislaan 34', '5215 AB', '073-3232323', 'blauw@email.com', null, 2, 2, 2, 'Tweeling babies'],
            ['Meneer Geel', 'Violenstraat 56', '5215 CD', '073-3333334', 'geel@email.com', 'Diabetisch', 1, 1, 0, 'Type 1 diabetes'],
            ['Familie Rood', 'Fresia laan 78', '5215 EF', '073-3434343', 'rood@email.com', null, 2, 4, 0, 'Kinderrijk gezin'],
            ['Mevrouw Paars', 'Begoniastraat 90', '5215 GH', '073-3535353', 'paars@email.com', null, 1, 1, 0, 'Student met kind'],
            ['Familie Oranje', 'Azaleastraat 12', '5215 IJ', '073-3636363', 'oranje@email.com', 'Halal', 2, 3, 0, 'Traditioneel gezin'],
            ['Meneer Roze', 'Dahlia straat 34', '5215 KL', '073-3737373', 'roze@email.com', null, 1, 0, 0, 'Gepensioneerd'],
            ['Familie Bruin', 'Anjelierenstraat 56', '5215 MN', '073-3838383', 'bruin@email.com', 'Glutenvrij', 2, 1, 1, 'Baby en peuter'],
            ['Mevrouw Grijs', 'Geraniumstraat 78', '5216 AB', '073-3939393', 'grijs@email.com', null, 1, 2, 0, 'Weduwe met kinderen'],
            ['Familie Zilver', 'Petunia laan 90', '5216 CD', '073-4040404', 'zilver@email.com', 'Vegetarisch', 2, 1, 0, 'Bewuste keuze'],
            ['Meneer Goud', 'Zonnebloem straat 123', '5216 EF', '073-4141414', 'goud@email.com', null, 1, 3, 0, 'Vader van drie'],
            ['Familie Koper', 'Lavendelstraat 145', '5216 GH', '073-4242424', 'koper@email.com', 'Lactosevrij', 2, 2, 0, 'Gezin met allergieën'],
            ['Mevrouw Brons', 'Rozemarijnstraat 167', '5216 IJ', '073-4343434', 'brons@email.com', null, 1, 0, 0, 'Oudere dame'],
            ['Familie Diamant', 'Tijmstraat 189', '5216 KL', '073-4444445', 'diamant@email.com', 'Halal', 3, 5, 2, 'Zeer grote familie'],
        ];

        foreach ($additionalClients as $index => $clientData) {
            Client::create([
                'name' => $clientData[0],
                'address' => $clientData[1] . ', ' . $clientData[2] . ' Den Bosch',
                'postal_code' => $clientData[2],
                'phone' => $clientData[3],
                'email' => $clientData[4],
                'preference' => $clientData[5],
                'adults' => $clientData[6],
                'children' => $clientData[7],
                'babies' => $clientData[8],
                'comment' => $clientData[9],
                'isactive' => true,
            ]);
        }

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
