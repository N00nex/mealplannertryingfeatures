<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('units', function (Blueprint $table): void {
            $table->id();
            $table->decimal('quantity', 10, 2);
            $table->string('unit', 50);
            $table->timestamps();

            $table->unique(['quantity', 'unit']);
        });

        Schema::create('lebensmittel_unit', function (Blueprint $table): void {
            $table->foreignId('lebensmittel_id')
                ->constrained('lebensmittel_komplett')
                ->cascadeOnDelete();
            $table->foreignId('unit_id')
                ->constrained('units')
                ->cascadeOnDelete();

            $table->primary(['lebensmittel_id', 'unit_id']);
        });

        Schema::create('recipe_unit', function (Blueprint $table): void {
            $table->foreignId('recipe_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignId('unit_id')
                ->constrained('units')
                ->cascadeOnDelete();

            $table->primary(['recipe_id', 'unit_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recipe_unit');
        Schema::dropIfExists('lebensmittel_unit');
        Schema::dropIfExists('units');
    }
};
