<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // --- Tables RH ---
        $rhTables = [
            'payrolls',
            'leaves',
            'attendances',
            'contracts',
            'insurances',
            'leave_types'
        ];

        foreach ($rhTables as $table) {
            if (Schema::hasTable($table)) {
                Schema::table($table, function (Blueprint $tableBlueprint) use ($table) {
                    if (!Schema::hasColumn($table, 'employee_id')) {
                        $tableBlueprint->foreignId('employee_id')->nullable()->constrained()->cascadeOnDelete();
                    }
                });
            }
        }

        // --- Table pivot pour positions ---
        if (!Schema::hasTable('employee_position')) {
            Schema::create('employee_position', function (Blueprint $table) {
                $table->id();
                $table->foreignId('employee_id')->constrained()->cascadeOnDelete();
                $table->foreignId('position_id')->constrained()->cascadeOnDelete();
                $table->timestamps();
            });
        }

        // --- Projets ---
        if (Schema::hasTable('projects')) {
            Schema::table('projects', function (Blueprint $tableBlueprint) {
                if (!Schema::hasColumn('projects', 'employee_id')) {
                    $tableBlueprint->foreignId('employee_id')->nullable()->constrained()->cascadeOnDelete();
                }
            });
        }

        // --- Tâches ---
        if (Schema::hasTable('tasks')) {
            Schema::table('tasks', function (Blueprint $tableBlueprint) {
                if (!Schema::hasColumn('tasks', 'employee_id')) {
                    $tableBlueprint->foreignId('employee_id')->nullable()->constrained()->cascadeOnDelete();
                }
            });
        }

        // --- Messagerie (sender & recipient) ---
        if (Schema::hasTable('messages')) {
            Schema::table('messages', function (Blueprint $tableBlueprint) {
                if (!Schema::hasColumn('messages', 'sender_id')) {
                    $tableBlueprint->foreignId('sender_id')->nullable()->constrained('employees')->cascadeOnDelete();
                }
                if (!Schema::hasColumn('messages', 'recipient_id')) {
                    $tableBlueprint->foreignId('recipient_id')->nullable()->constrained('employees')->cascadeOnDelete();
                }
            });
        }

        // --- Employés ---
        if (!Schema::hasTable('employees')) {
            Schema::create('employees', function (Blueprint $table) {
                $table->id();
                $table->foreignId('filiale_id')->nullable()->constrained('filiales')->nullOnDelete();
                $table->foreignId('agency_id')->nullable()->constrained('agences')->nullOnDelete();
                $table->foreignId('department_id')->nullable()->constrained()->nullOnDelete();
                $table->foreignId('position_id')->nullable()->constrained()->nullOnDelete();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        // --- Supprimer colonnes RH ---
        $rhTables = [
            'payrolls',
            'leaves',
            'attendances',
            'contracts',
            'insurances',
            'leave_types'
        ];

        foreach ($rhTables as $table) {
            if (Schema::hasTable($table)) {
                Schema::table($table, function (Blueprint $tableBlueprint) use ($table) {
                    if (Schema::hasColumn($table, 'employee_id')) {
                        $tableBlueprint->dropForeign([$table . '_employee_id_foreign']);
                        $tableBlueprint->dropColumn('employee_id');
                    }
                });
            }
        }

        // --- Table pivot positions ---
        if (Schema::hasTable('employee_position')) {
            Schema::dropIfExists('employee_position');
        }

        // --- Projets ---
        if (Schema::hasTable('projects')) {
            Schema::table('projects', function (Blueprint $tableBlueprint) {
                if (Schema::hasColumn('projects', 'employee_id')) {
                    $tableBlueprint->dropForeign(['projects_employee_id_foreign']);
                    $tableBlueprint->dropColumn('employee_id');
                }
            });
        }

        // --- Tâches ---
        if (Schema::hasTable('tasks')) {
            Schema::table('tasks', function (Blueprint $tableBlueprint) {
                if (Schema::hasColumn('tasks', 'employee_id')) {
                    $tableBlueprint->dropForeign(['tasks_employee_id_foreign']);
                    $tableBlueprint->dropColumn('employee_id');
                }
            });
        }

        // --- Messagerie ---
        if (Schema::hasTable('messages')) {
            Schema::table('messages', function (Blueprint $tableBlueprint) {
                if (Schema::hasColumn('messages', 'sender_id')) {
                    $tableBlueprint->dropForeign(['messages_sender_id_foreign']);
                    $tableBlueprint->dropColumn('sender_id');
                }
                if (Schema::hasColumn('messages', 'recipient_id')) {
                    $tableBlueprint->dropForeign(['messages_recipient_id_foreign']);
                    $tableBlueprint->dropColumn('recipient_id');
                }
            });
        }

        // --- Employés ---
        if (Schema::hasTable('employees')) {
            Schema::dropIfExists('employees');
        }
    }
};
