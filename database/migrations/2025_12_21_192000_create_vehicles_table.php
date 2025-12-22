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
        if (!Schema::hasTable('vehicles')) {
            Schema::create('vehicles', function (Blueprint $table) {
                $table->id();
                $table->string('immatriculation')->unique();
                $table->string('marque');
                $table->string('modele');
                $table->integer('annee')->nullable();
                $table->enum('type', ['voiture', 'camion', 'moto', 'bus', 'utilitaire', 'autre'])->default('voiture');
                
                $table->string('couleur')->nullable();
                $table->string('numero_chassis')->nullable();
                $table->integer('kilometrage')->default(0);
                
                // Propriété
                $table->enum('proprietaire', ['entreprise', 'location', 'personnel'])->default('entreprise');
                $table->date('date_acquisition')->nullable();
                $table->decimal('prix_acquisition', 15, 2)->nullable();
                
                // Assurance
                $table->string('assureur')->nullable();
                $table->string('numero_police')->nullable();
                $table->date('date_debut_assurance')->nullable();
                $table->date('date_fin_assurance')->nullable();
                $table->decimal('montant_assurance', 15, 2)->nullable();
                
                // Contrôle technique
                $table->date('derniere_visite_technique')->nullable();
                $table->date('prochaine_visite_technique')->nullable();
                
                // État et disponibilité
                $table->enum('etat', ['excellent', 'bon', 'moyen', 'mauvais'])->default('bon');
                $table->enum('statut', ['disponible', 'en_mission', 'en_maintenance', 'en_panne', 'reforme'])->default('disponible');
                
                // Affectation
                $table->foreignId('chauffeur_attitule_id')->nullable()->constrained('users')->onDelete('set null');
                $table->foreignId('affecte_a_service')->nullable()->constrained('departments')->onDelete('set null');
                
                // Maintenance
                $table->date('derniere_maintenance')->nullable();
                $table->date('prochaine_maintenance')->nullable();
                $table->integer('frequence_maintenance_km')->nullable();
                
                // Capacités
                $table->integer('nombre_places')->nullable();
                $table->decimal('capacite_charge_kg', 10, 2)->nullable();
                $table->string('type_carburant')->nullable(); // Essence, Diesel, Électrique
                $table->decimal('consommation_moyenne', 5, 2)->nullable(); // L/100km
                
                // Documents
                $table->json('attachments')->nullable(); // Carte grise, assurance, photos
                
                // Associations
                $table->foreignId('filiale_id')->nullable()->constrained('filiales')->onDelete('cascade');
                $table->foreignId('agence_id')->nullable()->constrained('agences')->onDelete('cascade');
                
                $table->timestamps();
                $table->softDeletes();
                
                $table->index(['statut', 'type']);
                $table->index(['filiale_id', 'agence_id']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
