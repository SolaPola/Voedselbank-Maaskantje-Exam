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
        Schema::create('food_packages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('clients');
            $table->string('soort_voedselpakket')->nullable();
            $table->string('gezinssamenstelling')->nullable();
            $table->timestamp('issued_at')->nullable();
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
        Schema::dropIfExists('food_packages');
    }
};
