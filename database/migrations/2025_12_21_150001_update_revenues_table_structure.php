<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Renommer 'title' en 'description' dans revenues si title existe
        if (Schema::hasColumn('revenues', 'title') && !Schema::hasColumn('revenues', 'description')) {
            Schema::table('revenues', function (Blueprint $table) {
                $table->renameColumn('title', 'description');
            });
        }
        // Sinon, juste ajouter description si elle n'existe pas
        elseif (!Schema::hasColumn('revenues', 'description')) {
            Schema::table('revenues', function (Blueprint $table) {
                $table->text('description')->nullable()->after('id');
            });
        }

        // Supprimer l'ancienne colonne description si elle existe et que title a été renommé
        if (Schema::hasColumn('revenues', 'title') && Schema::hasColumn('revenues', 'description')) {
            Schema::table('revenues', function (Blueprint $table) {
                $table->dropColumn('title');
            });
        }

        // Modifier la colonne date pour être de type date (pas datetime)
        if (Schema::hasColumn('revenues', 'date')) {
            Schema::table('revenues', function (Blueprint $table) {
                $table->date('date')->change();
            });
        }
    }

    public function down(): void
    {
        // Pas de retour en arrière pour éviter la perte de données
    }
};
