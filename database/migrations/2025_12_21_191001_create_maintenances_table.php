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
        if (!Schema::hasTable('maintenances')) {
            Schema::create('maintenances', function (Blueprint $table) {
                $table->id();
                $table->string('numero')->unique();
                $table->foreignId('equipment_id')->constrained('equipment')->onDelete('cascade');
                
                $table->enum('type', ['preventive', 'corrective', 'ameliorative'])->default('preventive');
                $table->enum('priorite', ['basse', 'normale', 'haute', 'urgente'])->default('normale');
                
                $table->string('titre');
                $table->text('description')->nullable();
                
                // Planification
                $table->date('date_prevue');
                $table->date('date_realisation')->nullable();
                $table->time('heure_debut')->nullable();
                $table->time('heure_fin')->nullable();
                
                $table->enum('statut', ['planifiee', 'en_cours', 'terminee', 'annulee', 'reportee'])->default('planifiee');
                
                // Exécution
                $table->foreignId('technicien_id')->nullable()->constrained('users')->onDelete('set null');
                $table->text('travaux_realises')->nullable();
                $table->text('pieces_remplacees')->nullable();
                
                // Coûts
                $table->decimal('cout_main_oeuvre', 15, 2)->default(0);
                $table->decimal('cout_pieces', 15, 2)->default(0);
                $table->decimal('cout_total', 15, 2)->default(0);
                
                // Résultat
                $table->boolean('reussite')->default(true);
                $table->text('observations')->nullable();
                $table->date('prochaine_maintenance')->nullable();
                
                // Documents
                $table->json('attachments')->nullable();
                
                $table->foreignId('created_by')->constrained('users');
                $table->timestamps();
                
                $table->index(['equipment_id', 'date_prevue']);
                $table->index(['statut', 'type']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maintenances');
    }
};
