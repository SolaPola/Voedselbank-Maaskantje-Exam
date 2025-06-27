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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('categoryid')->constrained('categories');
            $table->string('ean_code')->nullable();
            $table->string('category');
            $table->integer('stock')->default(0);
            $table->date('expiry_date')->nullable();
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
        Schema::dropIfExists('products');
    }
};
