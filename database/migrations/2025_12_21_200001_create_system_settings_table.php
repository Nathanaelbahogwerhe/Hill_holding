<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('system_settings')) {
            Schema::create('system_settings', function (Blueprint $table) {
                $table->id();
                $table->string('category'); // general, email, security, maintenance, etc.
                $table->string('key')->unique();
                $table->text('value')->nullable();
                $table->string('type')->default('text'); // text, boolean, number, json
                $table->text('description')->nullable();
                $table->boolean('is_public')->default(false); // visible to non-admins
                $table->timestamps();
                
                $table->index(['category', 'key']);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('system_settings');
    }
};
