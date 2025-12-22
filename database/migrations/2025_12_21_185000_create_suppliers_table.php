<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('suppliers')) {
            Schema::create('suppliers', function (Blueprint $table) {
                $table->id();
                $table->foreignId('filiale_id')->nullable()->constrained('filiales')->onDelete('cascade');
                $table->string('nom');
                $table->string('code')->unique()->nullable();
                $table->string('type')->nullable(); // fournisseur, prestataire, etc.
                $table->string('email')->nullable();
                $table->string('telephone')->nullable();
                $table->string('adresse')->nullable();
                $table->string('ville')->nullable();
                $table->string('pays')->default('Cameroun');
                $table->string('contact_principal')->nullable();
                $table->string('telephone_contact')->nullable();
                $table->text('specialites')->nullable();
                $table->string('numero_contribuable')->nullable();
                $table->enum('statut', ['actif', 'inactif', 'suspendu'])->default('actif');
                $table->text('remarques')->nullable();
                $table->timestamps();
                
                $table->index('filiale_id');
                $table->index('statut');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('suppliers');
    }
};
