<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            // Vérifie si la colonne existe pour éviter les erreurs
            if (Schema::hasColumn('tasks', 'assigned_to')) {
                $table->renameColumn('assigned_to', 'employee_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            if (Schema::hasColumn('tasks', 'employee_id')) {
                $table->renameColumn('employee_id', 'assigned_to');
            }
        });
    }
};
