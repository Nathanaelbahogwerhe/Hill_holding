<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('reports')) {
            return;
        }
        
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->enum('type', ['journalier', 'hebdomadaire', 'mensuel', 'projet', 'mission', 'département'])->default('journalier');
            $table->text('contenu');
            $table->date('date_debut')->nullable();
            $table->date('date_fin')->nullable();
            $table->enum('statut', ['brouillon', 'soumis', 'validé', 'rejeté'])->default('brouillon');
            
            // Traçabilité
            $table->foreignId('soumis_par')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('valide_par')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('date_soumission')->nullable();
            $table->timestamp('date_validation')->nullable();
            $table->text('commentaires')->nullable();
            
            // Fichiers attachés (JSON array de chemins)
            $table->text('attachments')->nullable();
            
            // Relations
            $table->foreignId('project_id')->nullable()->constrained('projects')->onDelete('cascade');
            $table->foreignId('department_id')->nullable()->constrained('departments')->onDelete('cascade');
            $table->foreignId('filiale_id')->nullable()->constrained('filiales')->onDelete('cascade');
            $table->foreignId('agence_id')->nullable()->constrained('agences')->onDelete('cascade');
            
            $table->timestamps();

            // Index pour performances
            $table->index(['type', 'statut']);
            $table->index(['date_debut', 'date_fin']);
            $table->index('soumis_par');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
