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
        if (!Schema::hasTable('vehicle_maintenances')) {
            Schema::create('vehicle_maintenances', function (Blueprint $table) {
                $table->id();
                $table->string('numero')->unique();
                $table->foreignId('vehicle_id')->constrained('vehicles')->onDelete('cascade');
                
                $table->enum('type', ['vidange', 'revision', 'reparation', 'pneus', 'freins', 'batterie', 'visite_technique', 'autre'])->default('revision');
                $table->enum('priorite', ['basse', 'normale', 'haute', 'urgente'])->default('normale');
                
                $table->string('titre');
                $table->text('description')->nullable();
                
                // Planification
                $table->date('date_prevue');
                $table->date('date_realisation')->nullable();
                $table->integer('kilometrage_au_moment')->nullable();
                
                $table->enum('statut', ['planifiee', 'en_cours', 'terminee', 'annulee'])->default('planifiee');
                
                // Prestataire
                $table->enum('lieu', ['interne', 'garage', 'concessionnaire', 'autre'])->default('garage');
                $table->string('nom_prestataire')->nullable();
                $table->foreignId('supplier_id')->nullable()->constrained('suppliers')->onDelete('set null');
                
                // Travaux
                $table->text('travaux_realises')->nullable();
                $table->text('pieces_remplacees')->nullable();
                $table->text('observations')->nullable();
                
                // Coûts
                $table->decimal('cout_main_oeuvre', 15, 2)->default(0);
                $table->decimal('cout_pieces', 15, 2)->default(0);
                $table->decimal('autres_frais', 15, 2)->default(0);
                $table->decimal('cout_total', 15, 2)->default(0);
                
                // Suivi
                $table->integer('km_prochaine_maintenance')->nullable();
                $table->date('date_prochaine_maintenance')->nullable();
                
                // Documents
                $table->json('attachments')->nullable(); // Facture, rapport, photos
                
                // Validation
                $table->foreignId('responsable_id')->nullable()->constrained('users')->onDelete('set null');
                $table->foreignId('valide_par')->nullable()->constrained('users')->onDelete('set null');
                
                $table->foreignId('created_by')->constrained('users');
                $table->timestamps();
                
                $table->index(['vehicle_id', 'date_prevue']);
                $table->index(['statut', 'type']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicle_maintenances');
    }
};
