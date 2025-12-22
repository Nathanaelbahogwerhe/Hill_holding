<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Ajouter la colonne category aux expenses pour liaison avec budgets
        if (!Schema::hasColumn('expenses', 'category')) {
            Schema::table('expenses', function (Blueprint $table) {
                $table->string('category', 100)->nullable()->after('date');
            });
        }

        // Renommer 'title' en 'description' si title existe
        if (Schema::hasColumn('expenses', 'title') && !Schema::hasColumn('expenses', 'description')) {
            Schema::table('expenses', function (Blueprint $table) {
                $table->renameColumn('title', 'description');
            });
        }
        // Sinon, juste ajouter description si elle n'existe pas
        elseif (!Schema::hasColumn('expenses', 'description')) {
            Schema::table('expenses', function (Blueprint $table) {
                $table->text('description')->nullable()->after('id');
            });
        }

        // Supprimer l'ancienne colonne description si elle existe et que title a été renommé
        if (Schema::hasColumn('expenses', 'title') && Schema::hasColumn('expenses', 'description')) {
            // Garder la nouvelle description (ancien title), supprimer l'ancienne description
            Schema::table('expenses', function (Blueprint $table) {
                $table->dropColumn('title');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('expenses', 'category')) {
            Schema::table('expenses', function (Blueprint $table) {
                $table->dropColumn('category');
            });
        }

        // Pas de retour en arrière pour le renommage pour éviter la perte de données
    }
};
