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
        Schema::table('transactions', function (Blueprint $table) {
            $table->unsignedBigInteger('filiale_id')->after('id')->nullable();

            // Si tu veux relier à une table filiales
            $table->foreign('filiale_id')->references('id')->on('filiales')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropForeign(['filiale_id']);
            $table->dropColumn('filiale_id');
        });
    }

};




