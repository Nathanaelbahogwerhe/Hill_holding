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
        // Ajouter responsible_id à la table activities
        if (!Schema::hasColumn('activities', 'responsible_id')) {
            Schema::table('activities', function (Blueprint $table) {
                $table->foreignId('responsible_id')->nullable()->after('created_by')->constrained('users')->onDelete('set null');
            });
        }

        // Créer la table pivot pour les participants
        if (!Schema::hasTable('activity_participants')) {
            Schema::create('activity_participants', function (Blueprint $table) {
                $table->id();
                $table->foreignId('activity_id')->constrained('activities')->onDelete('cascade');
                $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
                $table->timestamps();
                
                // Index unique pour éviter les doublons
                $table->unique(['activity_id', 'user_id']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_participants');
        
        if (Schema::hasColumn('activities', 'responsible_id')) {
            Schema::table('activities', function (Blueprint $table) {
                $table->dropForeign(['responsible_id']);
                $table->dropColumn('responsible_id');
            });
        }
    }
};
