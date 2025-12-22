<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('employees', 'attachment')) {
            Schema::table('employees', function (Blueprint $table) {
                $table->string('attachment')->nullable()->after('basic_salary');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('employees', 'attachment')) {
            Schema::table('employees', function (Blueprint $table) {
                $table->dropColumn('attachment');
            });
        }
    }
};
