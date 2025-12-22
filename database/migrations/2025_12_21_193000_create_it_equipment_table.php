<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('it_equipment')) {
            Schema::create('it_equipment', function (Blueprint $table) {
                $table->id();
                $table->string('numero')->unique(); // IT-YYYYMMDD-####
                $table->foreignId('filiale_id')->nullable()->constrained('filiales')->onDelete('cascade');
                $table->foreignId('agence_id')->nullable()->constrained('agences')->onDelete('cascade');
                $table->foreignId('department_id')->nullable()->constrained('departments')->onDelete('set null');
                
                // Identification
                $table->enum('type', ['ordinateur', 'portable', 'serveur', 'imprimante', 'scanner', 'switch', 'routeur', 'autre'])->default('ordinateur');
                $table->string('marque')->nullable();
                $table->string('modele')->nullable();
                $table->string('numero_serie')->unique()->nullable();
                $table->string('processeur')->nullable();
                $table->string('ram')->nullable(); // 8GB, 16GB, etc.
                $table->string('disque_dur')->nullable(); // 256GB SSD, 1TB HDD
                $table->string('systeme_exploitation')->nullable();
                
                // Attribution
                $table->foreignId('utilisateur_id')->nullable()->constrained('users')->onDelete('set null');
                $table->date('date_attribution')->nullable();
                $table->string('localisation')->nullable();
                
                // Acquisition
                $table->date('date_acquisition')->nullable();
                $table->decimal('prix_acquisition', 15, 2)->nullable();
                $table->foreignId('supplier_id')->nullable()->constrained('suppliers')->onDelete('set null');
                $table->date('date_fin_garantie')->nullable();
                
                // État
                $table->enum('statut', ['disponible', 'en_service', 'en_reparation', 'hors_service', 'reforme'])->default('disponible');
                $table->enum('etat', ['excellent', 'bon', 'moyen', 'mauvais'])->default('bon');
                
                // Informations complémentaires
                $table->text('configuration_details')->nullable();
                $table->text('remarques')->nullable();
                
                $table->timestamps();
                
                $table->index(['filiale_id', 'type', 'statut']);
                $table->index('utilisateur_id');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('it_equipment');
    }
};
