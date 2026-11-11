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
        Schema::create('recipe_lebensmittel', function (Blueprint $table): void {
            $table->foreignId('recipe_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignId('lebensmittel_id')
                ->constrained('lebensmittel_komplett')
                ->cascadeOnDelete();
            $table->foreignId('unit_id')
                ->constrained('units')
                ->restrictOnDelete();

            $table->primary(['recipe_id', 'lebensmittel_id']);
            $table->index('unit_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recipe_lebensmittel');
    }
};
