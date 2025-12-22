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
        if (!Schema::hasTable('receptions')) {
            Schema::create('receptions', function (Blueprint $table) {
                $table->id();
                $table->string('numero')->unique();
                $table->foreignId('purchase_order_id')->constrained('purchase_orders');
                
                $table->date('date_reception');
                $table->time('heure_reception')->nullable();
                $table->string('receptionnaire'); // Nom de la personne qui réceptionne
                
                $table->enum('statut', ['partielle', 'complete', 'avec_reserves'])->default('complete');
                $table->text('articles_recus'); // JSON ou texte structuré
                $table->text('reserves')->nullable(); // Observations, manques, dégâts
                
                // Conformité
                $table->boolean('conforme')->default(true);
                $table->text('non_conformites')->nullable();
                $table->text('actions_requises')->nullable();
                
                // Documents
                $table->json('attachments')->nullable(); // Photos, bon de livraison scanné
                
                // Associations
                $table->foreignId('filiale_id')->nullable()->constrained('filiales')->onDelete('cascade');
                $table->foreignId('agence_id')->nullable()->constrained('agences')->onDelete('cascade');
                
                $table->foreignId('created_by')->constrained('users');
                $table->timestamps();
                
                $table->index(['purchase_order_id', 'date_reception']);
                $table->index(['statut', 'conforme']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('receptions');
    }
};
