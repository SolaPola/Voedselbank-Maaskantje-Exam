<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('package_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('food_package_id')->constrained('food_packages')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->string('product_name');
            $table->integer('amount');
            $table->text('comment')->nullable();
            $table->boolean('isactive')->default(true);
            $table->timestamp('dateadded')->useCurrent();
            $table->timestamp('datechanged')->useCurrent()->useCurrentOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('package_items');
    }
};
