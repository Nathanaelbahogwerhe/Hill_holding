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
        if (!Schema::hasTable('fuel_records')) {
            Schema::create('fuel_records', function (Blueprint $table) {
                $table->id();
                $table->foreignId('vehicle_id')->constrained('vehicles');
                $table->foreignId('mission_id')->nullable()->constrained('missions')->onDelete('set null');
                
                $table->dateTime('date_heure');
                $table->enum('type_carburant', ['essence', 'diesel', 'gaz', 'electrique', 'hybride'])->default('essence');
                
                // Quantités
                $table->decimal('quantite_litres', 8, 2);
                $table->decimal('prix_unitaire', 10, 2);
                $table->decimal('montant_total', 15, 2);
                
                // Kilométrage au moment du plein
                $table->integer('kilometrage');
                $table->integer('km_depuis_dernier_plein')->nullable();
                
                // Consommation calculée
                $table->decimal('consommation_calculee', 5, 2)->nullable(); // L/100km
                
                // Station-service
                $table->string('station_service')->nullable();
                $table->string('lieu')->nullable();
                
                // Paiement
                $table->enum('mode_paiement', ['carte_entreprise', 'especes', 'bon_carburant', 'autre'])->default('carte_entreprise');
                $table->string('numero_facture')->nullable();
                
                // Validation
                $table->foreignId('effectue_par')->constrained('users'); // Chauffeur ou responsable
                $table->foreignId('valide_par')->nullable()->constrained('users')->onDelete('set null');
                $table->boolean('valide')->default(false);
                
                $table->text('observations')->nullable();
                
                // Documents
                $table->json('attachments')->nullable(); // Facture, bon de carburant
                
                $table->timestamps();
                
                $table->index(['vehicle_id', 'date_heure']);
                $table->index(['mission_id']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fuel_records');
    }
};
