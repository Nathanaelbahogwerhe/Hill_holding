<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('agences', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('filiale_id')->nullable()->constrained()->onDelete('set null');
            $table->timestamps();
        });

        Schema::table('agences', function (Blueprint $table) {
            $table->string('logo')->nullable()->after('name');
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('agences');
    }
};




