<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('o_f_f_ingredients', function (Blueprint $table) {
            $table->id();
            $table->string('barcode')->unique();

            // Wenn du Option A (JSON-Spalten) nutzt:
            $table->json('names')->nullable();
            $table->json('nutriments')->nullable();

            // Alternativ für Option B (Einzelspalten):
            // $table->string('name_en')->nullable();
            // $table->string('name_de')->nullable();
            // $table->decimal('energy_kcal', 8, 2)->nullable();
            // ... (weitere Nährstoff-Spalten als decimal/float)

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('o_f_f_ingredients');
    }
};
