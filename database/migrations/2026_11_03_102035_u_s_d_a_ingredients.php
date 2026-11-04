<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('u_s_d_a_ingredients', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('fdc_id')->unique(); // USDA ID als eindeutiger Key
            $table->json('names')->nullable();             // Namen (en, de)
            $table->json('nutriments')->nullable();        // Nährwerte pro 100g als JSON
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('u_s_d_a_ingredients');
    }
};
