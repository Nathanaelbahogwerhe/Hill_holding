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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // ✅ nom du projet
            $table->text('description')->nullable(); // ✅ description
            $table->text('details')->nullable(); // ✅ détails supplémentaires
            $table->date('start_date')->nullable(); // ✅ date de début
            $table->date('end_date')->nullable(); // date de fin prévue
            $table->date('due_date')->nullable(); // ✅ date d’échéance
            $table->unsignedBigInteger('responsible_id')->nullable(); // ✅ responsable
            $table->enum('status', ['pending', 'in_progress', 'completed'])->default('pending'); // ✅ statut
            $table->unsignedBigInteger('created_by')->nullable(); // qui a créé le projet ?
            $table->timestamps();

            // clé étrangère pour l’utilisateur qui a créé
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};




