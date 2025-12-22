<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nom de l’actif
            $table->string('category'); // Catégorie (ex : véhicule, matériel, logiciel…)
            $table->decimal('value', 15, 2)->nullable(); // Valeur d’achat
            $table->date('acquisition_date')->nullable(); // Date d’acquisition
            $table->string('status')->default('active'); // Statut : actif, hors service…
            $table->text('description')->nullable(); // Détails
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};




