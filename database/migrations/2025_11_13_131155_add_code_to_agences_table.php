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
        Schema::table('agences', function (Blueprint $table) {
            if (!Schema::hasColumn('agences', 'code')) {
                $table->string('code')->unique()->after('id');
            }
            if (!Schema::hasColumn('agences', 'adresse')) {
                $table->string('adresse')->nullable()->after('name');
            }
            if (!Schema::hasColumn('agences', 'email')) {
                $table->string('email')->nullable()->after('adresse');
            }
            if (!Schema::hasColumn('agences', 'telephone')) {
                $table->string('telephone')->nullable()->after('email');
            }
            if (!Schema::hasColumn('agences', 'filiale_id')) {
                $table->foreignId('filiale_id')->nullable()->constrained()->onDelete('cascade');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('agences', function (Blueprint $table) {
            if (Schema::hasColumn('agences', 'code')) {
                $table->dropColumn('code');
            }
            if (Schema::hasColumn('agences', 'filiale_id')) {
                $table->dropForeign(['filiale_id']);
                $table->dropColumn('filiale_id');
            }
            if (Schema::hasColumn('agences', 'adresse')) {
                $table->dropColumn('adresse');
            }
            if (Schema::hasColumn('agences', 'email')) {
                $table->dropColumn('email');
            }
            if (Schema::hasColumn('agences', 'telephone')) {
                $table->dropColumn('telephone');
            }
        });
    }
};




