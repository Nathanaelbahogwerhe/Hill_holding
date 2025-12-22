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
        if (!Schema::hasTable('breakdowns')) {
            Schema::create('breakdowns', function (Blueprint $table) {
                $table->id();
                $table->string('numero')->unique();
                $table->foreignId('equipment_id')->constrained('equipment')->onDelete('cascade');
                
                $table->dateTime('date_panne');
                $table->dateTime('date_resolution')->nullable();
                
                $table->enum('severite', ['mineure', 'moderee', 'majeure', 'critique'])->default('moderee');
                $table->enum('statut', ['declaree', 'en_diagnostic', 'en_reparation', 'resolue', 'non_resolue'])->default('declaree');
                
                $table->string('titre');
                $table->text('description');
                $table->text('symptomes')->nullable();
                $table->text('cause_identifiee')->nullable();
                
                // Déclaration
                $table->foreignId('declarant_id')->constrained('users');
                $table->boolean('impacte_production')->default(false);
                $table->text('impact_description')->nullable();
                
                // Intervention
                $table->foreignId('technicien_assigne_id')->nullable()->constrained('users')->onDelete('set null');
                $table->dateTime('date_intervention')->nullable();
                $table->text('actions_correctives')->nullable();
                $table->text('pieces_remplacees')->nullable();
                
                // Coûts
                $table->decimal('cout_reparation', 15, 2)->default(0);
                $table->decimal('cout_pieces', 15, 2)->default(0);
                $table->decimal('cout_total', 15, 2)->default(0);
                
                // Temps d'arrêt
                $table->integer('duree_arret_minutes')->nullable();
                
                // Solution et prévention
                $table->text('solution_appliquee')->nullable();
                $table->text('mesures_preventives')->nullable();
                
                // Documents
                $table->json('attachments')->nullable();
                
                $table->timestamps();
                
                $table->index(['equipment_id', 'date_panne']);
                $table->index(['statut', 'severite']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('breakdowns');
    }
};
