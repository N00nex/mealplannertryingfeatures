<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        // lebensmittel_komplett is the existing imported source table.
    }

    public function down(): void
    {
        // The source table is managed outside this migration.
    }
};
