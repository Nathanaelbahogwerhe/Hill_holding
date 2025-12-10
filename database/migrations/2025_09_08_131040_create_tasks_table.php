<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // titre de la tÃ¢che
            $table->text('description')->nullable(); // description
            $table->enum('status', ['todo', 'doing', 'done'])->default('todo');
            $table->date('due_date')->nullable(); // date limite
            $table->foreignId('project_id')->nullable()->constrained()->onDelete('set null'); // relation avec projects
            $table->foreignId('assigned_to')->nullable()->constrained('employees')->onDelete('set null'); // relation avec employees
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};







