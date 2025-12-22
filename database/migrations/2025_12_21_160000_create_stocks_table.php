<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('stocks')) {
            return;
        }
        
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('articles');
            $table->decimal('quantite', 15, 2)->default(0);
            $table->decimal('prix_unitaire', 15, 2)->default(0);
            $table->decimal('prix_total', 15, 2)->default(0);
            $table->decimal('entree', 15, 2)->default(0)->comment('Quantité entrée');
            $table->decimal('sortie', 15, 2)->default(0)->comment('Quantité sortie');
            $table->string('destination')->nullable()->comment('Destination en cas de sortie');
            $table->decimal('solde', 15, 2)->default(0)->comment('Stock restant');
            $table->string('fournisseur')->nullable();
            $table->foreignId('filiale_id')->nullable()->constrained('filiales')->onDelete('cascade');
            $table->foreignId('agence_id')->nullable()->constrained('agences')->onDelete('cascade');
            $table->timestamps();

            // Index pour améliorer les performances
            $table->index(['articles', 'filiale_id', 'agence_id']);
            $table->index('date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stocks');
    }
};
