<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('daily_operations')) {
            return;
        }
        
        Schema::create('daily_operations', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->text('activites_realisees');
            $table->text('problemes_rencontres')->nullable();
            $table->text('solutions_apportees')->nullable();
            $table->text('previsions_lendemain')->nullable();
            $table->integer('nombre_personnel')->default(0);
            $table->text('observations')->nullable();
            $table->text('attachments')->nullable();
            
            // Relations
            $table->foreignId('project_id')->nullable()->constrained('projects')->onDelete('cascade');
            $table->foreignId('department_id')->nullable()->constrained('departments')->onDelete('cascade');
            $table->foreignId('filiale_id')->nullable()->constrained('filiales')->onDelete('cascade');
            $table->foreignId('agence_id')->nullable()->constrained('agences')->onDelete('cascade');
            $table->foreignId('soumis_par')->constrained('users')->onDelete('cascade');
            
            $table->timestamps();

            $table->index(['date', 'department_id']);
            $table->unique(['date', 'project_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('daily_operations');
    }
};
