<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Ajouter agence_id à budgets si pas déjà présent
        if (!Schema::hasColumn('budgets', 'agence_id')) {
            Schema::table('budgets', function (Blueprint $table) {
                $table->foreignId('agence_id')->nullable()->after('filiale_id')->constrained('agences')->onDelete('cascade');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('budgets', 'agence_id')) {
            Schema::table('budgets', function (Blueprint $table) {
                $table->dropForeign(['agence_id']);
                $table->dropColumn('agence_id');
            });
        }
    }
};
