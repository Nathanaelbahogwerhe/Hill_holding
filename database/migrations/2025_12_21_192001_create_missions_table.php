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
        if (!Schema::hasTable('missions')) {
            Schema::create('missions', function (Blueprint $table) {
                $table->id();
                $table->string('numero')->unique();
                $table->foreignId('vehicle_id')->constrained('vehicles');
                $table->foreignId('chauffeur_id')->constrained('users');
                
                $table->string('objet');
                $table->text('description')->nullable();
                
                // Dates et heures
                $table->dateTime('date_heure_depart');
                $table->dateTime('date_heure_retour_prevue');
                $table->dateTime('date_heure_retour_reel')->nullable();
                
                // Itinéraire
                $table->string('lieu_depart');
                $table->string('lieu_destination');
                $table->text('itineraire')->nullable(); // Points de passage
                $table->decimal('distance_km', 10, 2)->nullable();
                
                $table->enum('statut', ['planifiee', 'en_cours', 'terminee', 'annulee'])->default('planifiee');
                $table->enum('type', ['administrative', 'commerciale', 'technique', 'livraison', 'autre'])->default('autre');
                
                // Passagers
                $table->json('passagers')->nullable(); // IDs des passagers
                $table->integer('nombre_passagers')->default(0);
                
                // Kilométrage
                $table->integer('km_depart')->nullable();
                $table->integer('km_retour')->nullable();
                $table->integer('km_parcourus')->nullable();
                
                // Carburant
                $table->decimal('carburant_utilise_litres', 8, 2)->nullable();
                $table->decimal('cout_carburant', 15, 2)->nullable();
                
                // Péages et frais
                $table->decimal('frais_peage', 15, 2)->default(0);
                $table->decimal('autres_frais', 15, 2)->default(0);
                $table->decimal('cout_total', 15, 2)->default(0);
                $table->text('details_frais')->nullable();
                
                // Compte-rendu
                $table->text('observations')->nullable();
                $table->text('incidents')->nullable();
                $table->boolean('mission_reussie')->default(true);
                
                // Documents
                $table->json('attachments')->nullable(); // Ordres de mission, reçus
                
                // Validation
                $table->foreignId('autorise_par')->nullable()->constrained('users')->onDelete('set null');
                $table->foreignId('valide_par')->nullable()->constrained('users')->onDelete('set null');
                
                // Associations
                $table->foreignId('project_id')->nullable()->constrained('projects')->onDelete('set null');
                $table->foreignId('department_id')->nullable()->constrained('departments')->onDelete('set null');
                
                $table->foreignId('created_by')->constrained('users');
                $table->timestamps();
                
                $table->index(['vehicle_id', 'date_heure_depart']);
                $table->index(['chauffeur_id', 'statut']);
                $table->index(['statut', 'type']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('missions');
    }
};
