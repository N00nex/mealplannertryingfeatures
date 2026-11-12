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
        if (! Schema::hasColumn('recipes', 'difficulty')) {
            Schema::table('recipes', function (Blueprint $table): void {
                $table->string('difficulty')->default('simple')->after('description');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // The recipes table migration defines this column for new installations.
    }
};
