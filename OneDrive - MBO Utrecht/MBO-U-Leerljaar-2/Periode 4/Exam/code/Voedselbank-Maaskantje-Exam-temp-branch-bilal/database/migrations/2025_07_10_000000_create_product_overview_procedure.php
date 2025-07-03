<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::unprepared('
            DROP PROCEDURE IF EXISTS GetProductOverview;
            
            CREATE PROCEDURE GetProductOverview()
            BEGIN
                SELECT 
                    p.id,
                    p.name,
                    p.ean_code,
                    c.name AS category_name,
                    p.stock,
                    p.expiry_date,
                    p.comment,
                    p.isactive
                FROM products p
                LEFT JOIN categories c ON p.categoriesid = c.id
                ORDER BY 
                    CASE 
                        WHEN p.expiry_date <= DATE_ADD(CURDATE(), INTERVAL 7 DAY) THEN 0
                        ELSE 1
                    END,
                    p.expiry_date ASC,
                    p.name ASC;
            END
        ');
    }

    public function down(): void
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS GetProductOverview');
    }
};
