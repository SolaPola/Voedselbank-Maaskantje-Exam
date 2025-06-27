<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Drop and recreate the foreign key constraints with cascade delete
        Schema::table('package_items', function (Blueprint $table) {
            $table->dropForeign(['product_id']);
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
        
        // Also check if deliveries table exists and fix it
        if (Schema::hasTable('deliveries')) {
            Schema::table('deliveries', function (Blueprint $table) {
                $table->dropForeign(['product_id']);
                $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            });
        }
    }

    public function down(): void
    {
        Schema::table('package_items', function (Blueprint $table) {
            $table->dropForeign(['product_id']);
            $table->foreign('product_id')->references('id')->on('products');
        });
        
        if (Schema::hasTable('deliveries')) {
            Schema::table('deliveries', function (Blueprint $table) {
                $table->dropForeign(['product_id']);
                $table->foreign('product_id')->references('id')->on('products');
            });
        }
    }
};
