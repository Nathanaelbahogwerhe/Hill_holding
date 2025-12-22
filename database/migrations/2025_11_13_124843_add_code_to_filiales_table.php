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
        Schema::table('filiales', function (Blueprint $table) {
            $table->string('code')->unique()->after('id'); // ou après la colonne souhaitée
        });
    }

    public function down(): void
    {
        Schema::table('filiales', function (Blueprint $table) {
            $table->dropColumn('code');
        });
    }
};




