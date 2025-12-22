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
        if (!Schema::hasTable('equipment')) {
            Schema::create('equipment', function (Blueprint $table) {
                $table->id();
                $table->string('code')->unique();
                $table->string('nom');
                $table->enum('type', ['informatique', 'vehicule', 'machine', 'mobilier', 'electronique', 'autre'])->default('autre');
                $table->enum('categorie', ['immobilisation', 'consommable', 'location'])->default('immobilisation');
                
                $table->text('description')->nullable();
                $table->string('marque')->nullable();
                $table->string('modele')->nullable();
                $table->string('numero_serie')->nullable();
                
                // Acquisition
                $table->date('date_acquisition');
                $table->decimal('prix_acquisition', 15, 2);
                $table->foreignId('supplier_id')->nullable()->constrained('suppliers')->onDelete('set null');
                $table->string('numero_facture')->nullable();
                
                // Garantie
                $table->date('date_fin_garantie')->nullable();
                $table->integer('duree_garantie_mois')->nullable();
                
                // État et localisation
                $table->enum('etat', ['neuf', 'bon', 'moyen', 'mauvais', 'hors_service'])->default('bon');
                $table->enum('statut', ['disponible', 'en_service', 'en_maintenance', 'en_panne', 'reforme'])->default('disponible');
                $table->string('localisation')->nullable(); // Bureau, salle, etc.
                
                // Affectation
                $table->foreignId('affecte_a')->nullable()->constrained('users')->onDelete('set null');
                $table->date('date_affectation')->nullable();
                
                // Maintenance
                $table->date('derniere_maintenance')->nullable();
                $table->date('prochaine_maintenance')->nullable();
                $table->integer('frequence_maintenance_jours')->nullable();
                
                // Documents
                $table->json('attachments')->nullable(); // Manuel, facture, photos
                
                // Associations
                $table->foreignId('department_id')->nullable()->constrained('departments')->onDelete('set null');
                $table->foreignId('filiale_id')->nullable()->constrained('filiales')->onDelete('cascade');
                $table->foreignId('agence_id')->nullable()->constrained('agences')->onDelete('cascade');
                
                $table->timestamps();
                $table->softDeletes();
                
                $table->index(['type', 'statut']);
                $table->index(['filiale_id', 'agence_id']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipment');
    }
};
