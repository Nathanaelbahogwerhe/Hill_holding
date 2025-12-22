<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('software_licenses')) {
            Schema::create('software_licenses', function (Blueprint $table) {
                $table->id();
                $table->string('numero')->unique(); // LIC-YYYYMMDD-####
                $table->foreignId('filiale_id')->nullable()->constrained('filiales')->onDelete('cascade');
                
                // Logiciel
                $table->string('nom_logiciel');
                $table->string('editeur')->nullable();
                $table->string('version')->nullable();
                $table->enum('type', ['os', 'bureautique', 'antivirus', 'developpement', 'comptabilite', 'autre'])->default('autre');
                
                // Licence
                $table->string('numero_licence')->nullable();
                $table->string('cle_activation')->nullable();
                $table->enum('type_licence', ['perpetuelle', 'abonnement', 'volume', 'oem'])->default('abonnement');
                $table->integer('nombre_postes')->default(1);
                $table->integer('postes_utilises')->default(0);
                
                // Dates
                $table->date('date_achat')->nullable();
                $table->date('date_expiration')->nullable();
                $table->decimal('cout', 15, 2)->nullable();
                $table->enum('periode_facturation', ['mensuel', 'annuel', 'unique'])->nullable();
                
                // État
                $table->enum('statut', ['active', 'expiree', 'resiliee'])->default('active');
                
                // Informations complémentaires
                $table->foreignId('supplier_id')->nullable()->constrained('suppliers')->onDelete('set null');
                $table->text('remarques')->nullable();
                
                $table->timestamps();
                
                $table->index(['filiale_id', 'statut']);
                $table->index('date_expiration');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('software_licenses');
    }
};
