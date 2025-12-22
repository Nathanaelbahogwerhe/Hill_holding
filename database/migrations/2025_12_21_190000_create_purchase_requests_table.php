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
        if (!Schema::hasTable('purchase_requests')) {
            Schema::create('purchase_requests', function (Blueprint $table) {
                $table->id();
                $table->string('numero')->unique();
                $table->string('titre');
                $table->text('description')->nullable();
                $table->enum('type', ['equipement', 'fourniture', 'service', 'materiaux', 'autre'])->default('fourniture');
                $table->enum('priorite', ['basse', 'normale', 'haute', 'urgente'])->default('normale');
                $table->enum('statut', ['brouillon', 'soumise', 'approuvee', 'rejetee', 'commandee'])->default('brouillon');
                $table->decimal('montant_estime', 15, 2)->nullable();
                $table->date('date_besoin');
                $table->text('justification')->nullable();
                
                // Approbation
                $table->foreignId('demandeur_id')->constrained('users');
                $table->foreignId('approbateur_id')->nullable()->constrained('users');
                $table->dateTime('date_approbation')->nullable();
                $table->text('commentaire_approbation')->nullable();
                
                // Associations
                $table->foreignId('project_id')->nullable()->constrained('projects')->onDelete('set null');
                $table->foreignId('department_id')->nullable()->constrained('departments')->onDelete('set null');
                $table->foreignId('filiale_id')->nullable()->constrained('filiales')->onDelete('cascade');
                $table->foreignId('agence_id')->nullable()->constrained('agences')->onDelete('cascade');
                
                $table->timestamps();
                
                $table->index(['statut', 'priorite']);
                $table->index(['demandeur_id', 'created_at']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_requests');
    }
};
