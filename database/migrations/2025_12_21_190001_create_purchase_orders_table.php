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
        if (!Schema::hasTable('purchase_orders')) {
            Schema::create('purchase_orders', function (Blueprint $table) {
                $table->id();
                $table->string('numero')->unique();
                $table->foreignId('purchase_request_id')->nullable()->constrained('purchase_requests')->onDelete('set null');
                $table->foreignId('supplier_id')->constrained('suppliers');
                
                $table->date('date_commande');
                $table->date('date_livraison_prevue')->nullable();
                $table->enum('statut', ['brouillon', 'envoyee', 'confirmee', 'en_cours', 'livree', 'annulee'])->default('brouillon');
                
                // Montants
                $table->decimal('montant_ht', 15, 2);
                $table->decimal('tva', 15, 2)->default(0);
                $table->decimal('montant_ttc', 15, 2);
                
                // Conditions
                $table->enum('mode_paiement', ['comptant', 'virement', 'cheque', 'traite', 'autre'])->default('virement');
                $table->string('delai_paiement')->nullable(); // "30 jours", "45 jours", etc.
                $table->text('conditions_livraison')->nullable();
                $table->text('notes')->nullable();
                
                // Documents
                $table->json('attachments')->nullable();
                
                // Associations
                $table->foreignId('project_id')->nullable()->constrained('projects')->onDelete('set null');
                $table->foreignId('department_id')->nullable()->constrained('departments')->onDelete('set null');
                $table->foreignId('filiale_id')->nullable()->constrained('filiales')->onDelete('cascade');
                $table->foreignId('agence_id')->nullable()->constrained('agences')->onDelete('cascade');
                
                $table->foreignId('created_by')->constrained('users');
                $table->timestamps();
                
                $table->index(['statut', 'date_commande']);
                $table->index(['supplier_id', 'statut']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_orders');
    }
};
