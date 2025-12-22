<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('system_backups')) {
            Schema::create('system_backups', function (Blueprint $table) {
                $table->id();
                $table->string('filename');
                $table->string('type'); // full, database, files
                $table->bigInteger('size')->nullable(); // in bytes
                $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
                $table->enum('status', ['pending', 'completed', 'failed'])->default('pending');
                $table->text('error_message')->nullable();
                $table->timestamps();
                
                $table->index(['status', 'created_at']);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('system_backups');
    }
};
