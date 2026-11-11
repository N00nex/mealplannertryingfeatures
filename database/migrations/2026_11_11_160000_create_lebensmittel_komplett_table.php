<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lebensmittel_komplett', function (Blueprint $table): void {
            $table->unsignedBigInteger('id')->primary();
            $table->string('name');
            $table->text('synonyme')->nullable();
            $table->text('kategorie')->nullable();
            $table->float('energie_kilojoule_kj')->nullable();
            $table->float('energie_kilokalorien_kcal')->nullable();
            $table->float('fett_total_g')->nullable();
            $table->float('fettsaeuren_gesaettigt_g')->nullable();
            $table->float('kohlenhydrate_verfuegbar_g')->nullable();
            $table->float('zucker_g')->nullable();
            $table->float('nahrungsfasern_g')->nullable();
            $table->float('protein_g')->nullable();
            $table->float('salz_nacl_g')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lebensmittel_komplett');
    }
};
