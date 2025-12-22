<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('system_notifications')) {
            Schema::create('system_notifications', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->text('message');
                $table->enum('type', ['info', 'success', 'warning', 'error'])->default('info');
                $table->enum('target', ['all', 'admins', 'specific_role'])->default('all');
                $table->string('role_name')->nullable();
                $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
                $table->boolean('is_active')->default(true);
                $table->dateTime('expires_at')->nullable();
                $table->timestamps();
                
                $table->index(['is_active', 'target']);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('system_notifications');
    }
};
