<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::unprepared('
            DROP PROCEDURE IF EXISTS GetClientOverview;
            
            CREATE PROCEDURE GetClientOverview()
            BEGIN
                SELECT 
                    c.id,
                    c.name AS naam,
                    c.email,
                    c.phone AS telefoon,
                    (c.children + c.babies) AS kinderen,
                    MAX(fp.issued_at) AS laatste_uitgifte,
                    COUNT(fp.id) AS aantal_pakketten,
                    c.preference AS wensen
                FROM clients c
                LEFT JOIN food_packages fp ON c.id = fp.client_id AND fp.isactive = 1
                WHERE c.isactive = 1
                GROUP BY c.id, c.name, c.email, c.phone, c.children, c.babies, c.preference
                ORDER BY c.name;
            END
        ');
    }

    public function down(): void
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS GetClientOverview');
    }
};
