<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // ✅ Ajouter role
            if (!Schema::hasColumn('users', 'role')) {
                $table->string('role')->default('user')->after('password');
            }

            // ✅ Ajouter filiale_id
            if (!Schema::hasColumn('users', 'filiale_id')) {
                $table->unsignedBigInteger('filiale_id')->nullable()->after('role');
                $table->foreign('filiale_id')->references('id')->on('filiales')->nullOnDelete();
            }

            // ✅ Ajouter agence_id
            if (!Schema::hasColumn('users', 'agence_id')) {
                $table->unsignedBigInteger('agence_id')->nullable()->after('filiale_id');
                $table->foreign('agence_id')->references('id')->on('agences')->nullOnDelete();
            }

            // ✅ Ajouter logo
            if (!Schema::hasColumn('users', 'logo')) {
                $table->string('logo')->nullable()->after('agence_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'role')) {
                $table->dropColumn('role');
            }
            if (Schema::hasColumn('users', 'filiale_id')) {
                $table->dropForeign(['filiale_id']);
                $table->dropColumn('filiale_id');
            }
            if (Schema::hasColumn('users', 'agence_id')) {
                $table->dropForeign(['agence_id']);
                $table->dropColumn('agence_id');
            }
            if (Schema::hasColumn('users', 'logo')) {
                $table->dropColumn('logo');
            }
        });
    }
};




