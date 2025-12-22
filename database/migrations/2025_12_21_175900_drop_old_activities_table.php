<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Supprimer l'ancienne table activities si elle existe
        if (Schema::hasTable('activities')) {
            Schema::dropIfExists('activities');
        }
    }

    public function down(): void
    {
        // Ne pas recréer l'ancienne table
    }
};
