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
        // Evaluations
        if (Schema::hasTable('evaluations') && !Schema::hasColumn('evaluations', 'filiale_id')) {
            Schema::table('evaluations', function (Blueprint $table) {
                $table->foreignId('filiale_id')->nullable()->after('id')->constrained('filiales')->onDelete('cascade');
                $table->foreignId('agence_id')->nullable()->after('filiale_id')->constrained('agences')->onDelete('cascade');
            });
        }

        // Stocks
        if (Schema::hasTable('stocks') && !Schema::hasColumn('stocks', 'filiale_id')) {
            Schema::table('stocks', function (Blueprint $table) {
                $table->foreignId('filiale_id')->nullable()->after('id')->constrained('filiales')->onDelete('cascade');
                $table->foreignId('agence_id')->nullable()->after('filiale_id')->constrained('agences')->onDelete('cascade');
            });
        }

        // Reports
        if (Schema::hasTable('reports') && !Schema::hasColumn('reports', 'filiale_id')) {
            Schema::table('reports', function (Blueprint $table) {
                $table->foreignId('filiale_id')->nullable()->after('id')->constrained('filiales')->onDelete('cascade');
                $table->foreignId('agence_id')->nullable()->after('filiale_id')->constrained('agences')->onDelete('cascade');
            });
        }

        // Report Schedules
        if (Schema::hasTable('report_schedules') && !Schema::hasColumn('report_schedules', 'filiale_id')) {
            Schema::table('report_schedules', function (Blueprint $table) {
                $table->foreignId('filiale_id')->nullable()->after('id')->constrained('filiales')->onDelete('cascade');
                $table->foreignId('agence_id')->nullable()->after('filiale_id')->constrained('agences')->onDelete('cascade');
            });
        }

        // Maintenances - vérifier si les colonnes existent
        if (Schema::hasTable('maintenances') && !Schema::hasColumn('maintenances', 'filiale_id')) {
            Schema::table('maintenances', function (Blueprint $table) {
                $table->foreignId('filiale_id')->nullable()->after('equipment_id')->constrained('filiales')->onDelete('cascade');
                $table->foreignId('agence_id')->nullable()->after('filiale_id')->constrained('agences')->onDelete('cascade');
            });
        }

        // Breakdowns
        if (Schema::hasTable('breakdowns') && !Schema::hasColumn('breakdowns', 'filiale_id')) {
            Schema::table('breakdowns', function (Blueprint $table) {
                $table->foreignId('filiale_id')->nullable()->after('equipment_id')->constrained('filiales')->onDelete('cascade');
                $table->foreignId('agence_id')->nullable()->after('filiale_id')->constrained('agences')->onDelete('cascade');
            });
        }

        // Interventions
        if (Schema::hasTable('interventions') && !Schema::hasColumn('interventions', 'filiale_id')) {
            Schema::table('interventions', function (Blueprint $table) {
                $table->foreignId('filiale_id')->nullable()->after('breakdown_id')->constrained('filiales')->onDelete('cascade');
                $table->foreignId('agence_id')->nullable()->after('filiale_id')->constrained('agences')->onDelete('cascade');
            });
        }

        // Missions
        if (Schema::hasTable('missions') && !Schema::hasColumn('missions', 'filiale_id')) {
            Schema::table('missions', function (Blueprint $table) {
                $table->foreignId('filiale_id')->nullable()->after('vehicle_id')->constrained('filiales')->onDelete('cascade');
                $table->foreignId('agence_id')->nullable()->after('filiale_id')->constrained('agences')->onDelete('cascade');
            });
        }

        // Fuel Records
        if (Schema::hasTable('fuel_records') && !Schema::hasColumn('fuel_records', 'filiale_id')) {
            Schema::table('fuel_records', function (Blueprint $table) {
                $table->foreignId('filiale_id')->nullable()->after('vehicle_id')->constrained('filiales')->onDelete('cascade');
                $table->foreignId('agence_id')->nullable()->after('filiale_id')->constrained('agences')->onDelete('cascade');
            });
        }

        // Vehicle Maintenances
        if (Schema::hasTable('vehicle_maintenances') && !Schema::hasColumn('vehicle_maintenances', 'filiale_id')) {
            Schema::table('vehicle_maintenances', function (Blueprint $table) {
                $table->foreignId('filiale_id')->nullable()->after('vehicle_id')->constrained('filiales')->onDelete('cascade');
                $table->foreignId('agence_id')->nullable()->after('filiale_id')->constrained('agences')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $tables = [
            'evaluations', 'stocks', 'reports', 'report_schedules',
            'maintenances', 'breakdowns', 'interventions',
            'missions', 'fuel_records', 'vehicle_maintenances'
        ];

        foreach ($tables as $table) {
            if (Schema::hasTable($table)) {
                Schema::table($table, function (Blueprint $table) {
                    if (Schema::hasColumn($table->getTable(), 'filiale_id')) {
                        $table->dropForeign(['filiale_id']);
                        $table->dropColumn('filiale_id');
                    }
                    if (Schema::hasColumn($table->getTable(), 'agence_id')) {
                        $table->dropForeign(['agence_id']);
                        $table->dropColumn('agence_id');
                    }
                });
            }
        }
    }
};
