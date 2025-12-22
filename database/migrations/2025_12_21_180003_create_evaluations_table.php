<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('evaluations')) {
            return;
        }
        
        Schema::create('evaluations', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['projet', 'tâche', 'employé', 'mission'])->default('tâche');
            $table->integer('note')->comment('Note sur 10 ou 100');
            $table->text('commentaires')->nullable();
            $table->text('points_forts')->nullable();
            $table->text('points_amelioration')->nullable();
            $table->text('recommandations')->nullable();
            
            // Relations polymorphiques
            $table->morphs('evaluable'); // evaluable_type, evaluable_id
            
            // Qui a évalué
            $table->foreignId('evaluateur_id')->constrained('users')->onDelete('cascade');
            
            // Pour qui (optionnel, utilisé pour employés)
            $table->foreignId('evaluated_user_id')->nullable()->constrained('users')->onDelete('cascade');
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('evaluations');
    }
};
