<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            
            // Référence au client
            $table->foreignId('client_id')->constrained('clients')->onDelete('cascade');
            
            // Référence à l’agence (facultatif)
            $table->foreignId('agency_id')->nullable()->constrained('agences')->onDelete('set null');
            
            // Référence à l’utilisateur qui a créé la facture (facultatif)
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');

            // Informations de la facture
            $table->string('invoice_number')->nullable()->unique(); // facultatif
            $table->date('invoice_date');
            $table->date('due_date')->nullable();

            $table->decimal('amount', 12, 2); // Montant total

            // Statut limité à certaines valeurs
            $table->enum('status', ['pending', 'paid', 'canceled'])->default('pending');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
