<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $procedure = "
            CREATE PROCEDURE GetActiveSuppliers()
            BEGIN
                SELECT 
                    s.id,
                    s.name,
                    s.address,
                    s.contact_name,
                    s.contact_email,
                    s.phone,
                    s.next_delivery,
                    s.comment,
                    s.created_at,
                    s.updated_at,
                    COUNT(DISTINCT d.id) AS delivery_count,
                    MAX(d.delivery_date) AS last_delivery_date,
                    SUM(d.amount) AS total_products_delivered,
                    COUNT(DISTINCT p.id) AS product_types_delivered
                FROM 
                    suppliers s
                LEFT JOIN 
                    deliveries d ON s.id = d.supplier_id AND d.isactive = 1
                LEFT JOIN 
                    products p ON d.product_id = p.id AND p.isactive = 1
                WHERE 
                    s.isactive = 1
                GROUP BY 
                    s.id, s.name, s.address, s.contact_name, s.contact_email, 
                    s.phone, s.next_delivery, s.comment, s.created_at, s.updated_at
                ORDER BY 
                    s.name ASC;
            END;
        ";
        
        DB::unprepared($procedure);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $procedure = "DROP PROCEDURE IF EXISTS GetActiveSuppliers";
        DB::unprepared($procedure);
    }
};
