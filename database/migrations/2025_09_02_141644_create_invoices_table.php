<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            
            // RÃ©fÃ©rence au client
            $table->foreignId('client_id')->constrained('clients')->onDelete('cascade');
            
            // RÃ©fÃ©rence Ã  lâ€™agence (facultatif)
            $table->foreignId('agency_id')->nullable()->constrained('agences')->onDelete('set null');
            
            // RÃ©fÃ©rence Ã  lâ€™utilisateur qui a crÃ©Ã© la facture (facultatif)
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');

            // Informations de la facture
            $table->string('invoice_number')->nullable()->unique(); // facultatif
            $table->date('invoice_date');
            $table->date('due_date')->nullable();

            $table->decimal('amount', 12, 2); // Montant total

            // Statut limitÃ© Ã  certaines valeurs
            $table->enum('status', ['pending', 'paid', 'canceled'])->default('pending');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};



