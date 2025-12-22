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
        if (!Schema::hasTable('supplier_contracts')) {
            Schema::create('supplier_contracts', function (Blueprint $table) {
                $table->id();
                $table->string('reference')->unique();
                $table->foreignId('supplier_id')->constrained('suppliers');
                
                $table->string('titre');
                $table->enum('type', ['fourniture', 'prestation', 'maintenance', 'cadre', 'autre'])->default('fourniture');
                $table->text('description')->nullable();
                
                // Durée
                $table->date('date_debut');
                $table->date('date_fin');
                $table->enum('statut', ['brouillon', 'actif', 'suspendu', 'expire', 'resilie'])->default('brouillon');
                
                // Montants
                $table->decimal('montant_annuel', 15, 2)->nullable();
                $table->decimal('montant_total', 15, 2)->nullable();
                $table->string('devise')->default('XOF');
                
                // Conditions
                $table->text('conditions_paiement')->nullable();
                $table->text('conditions_livraison')->nullable();
                $table->text('clauses_particulieres')->nullable();
                $table->integer('delai_preavis_jours')->nullable(); // Pour résiliation
                
                // Renouvellement
                $table->boolean('renouvelable')->default(false);
                $table->enum('type_renouvellement', ['automatique', 'manuel', 'non_renouvelable'])->nullable();
                $table->date('date_prochain_renouvellement')->nullable();
                
                // Responsables
                $table->foreignId('responsable_interne_id')->nullable()->constrained('users');
                $table->string('contact_fournisseur')->nullable();
                
                // Documents
                $table->json('attachments')->nullable();
                
                // Associations
                $table->foreignId('department_id')->nullable()->constrained('departments')->onDelete('set null');
                $table->foreignId('filiale_id')->nullable()->constrained('filiales')->onDelete('cascade');
                
                $table->foreignId('created_by')->constrained('users');
                $table->timestamps();
                
                $table->index(['statut', 'date_fin']);
                $table->index(['supplier_id', 'statut']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supplier_contracts');
    }
};
