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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('address');
            $table->string('postal_code');
            $table->integer('phone');
            $table->string('email');
            $table->integer('adults')->default(0);
            $table->integer('children')->default(0);
            $table->integer('babies')->default(0);
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
        Schema::dropIfExists('clients');
    }
};
