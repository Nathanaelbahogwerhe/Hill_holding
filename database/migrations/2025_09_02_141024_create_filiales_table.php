<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
         Schema::create('filiales', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });

        Schema::table('filiales', function (Blueprint $table) {
            $table->string('logo')->nullable()->after('name');
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('filiales');
    }
};








