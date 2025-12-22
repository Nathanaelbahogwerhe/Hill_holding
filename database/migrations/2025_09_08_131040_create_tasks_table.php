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
            $table->string('title'); // titre de la tâche
            $table->text('description')->nullable(); // description
            $table->enum('status', ['todo', 'doing', 'done'])->default('todo');
            $table->date('due_date')->nullable(); // date limite

            // Relation avec projects
            $table->foreignId('project_id')->nullable()->constrained()->onDelete('set null');

            // Relation avec employees
            $table->foreignId('employee_id')->nullable()->constrained('employees')->onDelete('set null');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
