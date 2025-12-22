<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('it_interventions')) {
            Schema::create('it_interventions', function (Blueprint $table) {
                $table->id();
                $table->string('numero')->unique(); // ITINT-YYYYMMDD-####
                $table->foreignId('filiale_id')->nullable()->constrained('filiales')->onDelete('cascade');
                $table->foreignId('agence_id')->nullable()->constrained('agences')->onDelete('cascade');
                
                // Demandeur
                $table->foreignId('demandeur_id')->constrained('users')->onDelete('cascade');
                $table->foreignId('department_id')->nullable()->constrained('departments')->onDelete('set null');
                
                // Équipement concerné
                $table->foreignId('it_equipment_id')->nullable()->constrained('it_equipment')->onDelete('set null');
                
                // Intervention
                $table->enum('type', ['installation', 'configuration', 'depannage', 'maintenance', 'formation', 'autre'])->default('depannage');
                $table->enum('priorite', ['basse', 'normale', 'haute', 'urgente'])->default('normale');
                $table->string('objet');
                $table->text('description');
                
                // Traitement
                $table->foreignId('technicien_id')->nullable()->constrained('users')->onDelete('set null');
                $table->datetime('date_intervention')->nullable();
                $table->text('diagnostic')->nullable();
                $table->text('solution')->nullable();
                $table->decimal('duree_heures', 5, 2)->nullable();
                
                // État
                $table->enum('statut', ['ouverte', 'en_cours', 'en_attente', 'resolue', 'fermee'])->default('ouverte');
                $table->date('date_resolution')->nullable();
                
                // Satisfaction
                $table->integer('note_satisfaction')->nullable(); // 1-5
                $table->text('commentaire_satisfaction')->nullable();
                
                $table->text('remarques')->nullable();
                $table->timestamps();
                
                $table->index(['filiale_id', 'statut', 'priorite']);
                $table->index('technicien_id');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('it_interventions');
    }
};
