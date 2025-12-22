<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('report_schedules')) {
            return;
        }
        
        Schema::create('report_schedules', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->enum('type_rapport', ['journalier', 'hebdomadaire', 'mensuel']);
            $table->enum('frequence', ['daily', 'weekly', 'monthly']);
            
            // Configuration de la fréquence
            $table->integer('jour_semaine')->nullable()->comment('1-7 pour hebdomadaire');
            $table->integer('jour_mois')->nullable()->comment('1-31 pour mensuel');
            $table->time('heure_echeance')->nullable();
            
            // Responsabilités
            $table->foreignId('department_id')->nullable()->constrained('departments')->onDelete('cascade');
            $table->foreignId('responsable_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('filiale_id')->nullable()->constrained('filiales')->onDelete('cascade');
            $table->foreignId('agence_id')->nullable()->constrained('agences')->onDelete('cascade');
            
            // Suivi
            $table->boolean('active')->default(true);
            $table->timestamp('derniere_soumission')->nullable();
            $table->timestamp('prochaine_echeance')->nullable();
            
            $table->timestamps();

            // Index
            $table->index(['active', 'prochaine_echeance']);
            $table->index('department_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('report_schedules');
    }
};
