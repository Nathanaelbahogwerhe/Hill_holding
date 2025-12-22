<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Ajouter les colonnes hiérarchiques aux projects
        if (!Schema::hasColumn('projects', 'filiale_id')) {
            Schema::table('projects', function (Blueprint $table) {
                $table->foreignId('filiale_id')->nullable()->constrained('filiales')->onDelete('cascade');
                $table->foreignId('agence_id')->nullable()->constrained('agences')->onDelete('cascade');
            });
        }

        // Ajouter les colonnes hiérarchiques aux tasks
        if (!Schema::hasColumn('tasks', 'filiale_id')) {
            Schema::table('tasks', function (Blueprint $table) {
                $table->foreignId('filiale_id')->nullable()->constrained('filiales')->onDelete('cascade');
                $table->foreignId('agence_id')->nullable()->constrained('agences')->onDelete('cascade');
                $table->integer('progression')->default(0)->comment('Pourcentage 0-100');
                $table->text('attachments')->nullable();
            });
        }
    }

    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropForeign(['filiale_id']);
            $table->dropForeign(['agence_id']);
            $table->dropColumn(['filiale_id', 'agence_id']);
        });

        Schema::table('tasks', function (Blueprint $table) {
            $table->dropForeign(['filiale_id']);
            $table->dropForeign(['agence_id']);
            $table->dropColumn(['filiale_id', 'agence_id', 'progression', 'attachments']);
        });
    }
};
