<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('activities')) {
            Schema::dropIfExists('activities');
        }
        
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->text('description')->nullable();
            $table->enum('type', ['réunion', 'formation', 'mission', 'événement', 'autre'])->default('autre');
            $table->date('date_prevue');
            $table->time('heure_debut')->nullable();
            $table->time('heure_fin')->nullable();
            $table->string('lieu')->nullable();
            $table->enum('statut', ['planifiée', 'en_cours', 'terminée', 'annulée'])->default('planifiée');
            
            // Participants
            $table->text('participants')->nullable()->comment('JSON array de user IDs');
            
            // Relations
            $table->foreignId('project_id')->nullable()->constrained('projects')->onDelete('cascade');
            $table->foreignId('department_id')->nullable()->constrained('departments')->onDelete('cascade');
            $table->foreignId('filiale_id')->nullable()->constrained('filiales')->onDelete('cascade');
            $table->foreignId('agence_id')->nullable()->constrained('agences')->onDelete('cascade');
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            
            $table->timestamps();

            $table->index(['date_prevue', 'statut']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};
