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
        Schema::create('client_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained()->onDelete('cascade'); // relation avec clients
            $table->decimal('amount', 15, 2)->default(0); // montant du paiement
            $table->date('payment_date')->nullable(); // date du paiement
            $table->string('method')->nullable(); // mode de paiement
            $table->text('notes')->nullable(); // notes éventuelles
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_payments');
    }
};
