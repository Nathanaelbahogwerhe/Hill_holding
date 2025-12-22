<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('revenues', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Titre du revenu
            $table->decimal('amount', 15, 2);
            $table->text('description')->nullable();
            $table->dateTime('date');

            // Relations
            $table->foreignId('filiale_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('agence_id')->nullable()->constrained()->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('revenues');
    }
};




