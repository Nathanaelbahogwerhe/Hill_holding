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
        if (!Schema::hasTable('interventions')) {
            Schema::create('interventions', function (Blueprint $table) {
                $table->id();
                $table->string('numero')->unique();
                
                // Lien vers équipement, maintenance ou panne
                $table->foreignId('equipment_id')->constrained('equipment')->onDelete('cascade');
                $table->foreignId('maintenance_id')->nullable()->constrained('maintenances')->onDelete('set null');
                $table->foreignId('breakdown_id')->nullable()->constrained('breakdowns')->onDelete('set null');
                
                $table->enum('type', ['installation', 'reparation', 'diagnostic', 'configuration', 'formation', 'autre'])->default('reparation');
                $table->string('titre');
                $table->text('description')->nullable();
                
                // Planification
                $table->dateTime('date_heure_debut');
                $table->dateTime('date_heure_fin')->nullable();
                $table->integer('duree_minutes')->nullable();
                
                $table->enum('statut', ['planifiee', 'en_cours', 'terminee', 'annulee'])->default('planifiee');
                
                // Équipe
                $table->foreignId('technicien_principal_id')->constrained('users');
                $table->json('techniciens_secondaires')->nullable(); // IDs des autres techniciens
                
                // Travaux réalisés
                $table->text('travaux_effectues')->nullable();
                $table->text('outils_utilises')->nullable();
                $table->text('pieces_utilisees')->nullable();
                
                // Résultat
                $table->enum('resultat', ['succes', 'echec', 'partiel'])->nullable();
                $table->text('observations')->nullable();
                $table->text('recommandations')->nullable();
                
                // Signature client/demandeur
                $table->foreignId('valide_par')->nullable()->constrained('users')->onDelete('set null');
                $table->dateTime('date_validation')->nullable();
                
                // Documents
                $table->json('attachments')->nullable();
                
                $table->foreignId('created_by')->constrained('users');
                $table->timestamps();
                
                $table->index(['equipment_id', 'date_heure_debut']);
                $table->index(['statut', 'type']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('interventions');
    }
};
