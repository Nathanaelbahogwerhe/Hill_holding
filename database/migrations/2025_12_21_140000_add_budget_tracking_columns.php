<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('budgets', 'amount_used')) {
            Schema::table('budgets', function (Blueprint $table) {
                $table->decimal('amount_used', 15, 2)->default(0)->after('amount');
            });
        }

        if (!Schema::hasColumn('budgets', 'percentage_used')) {
            Schema::table('budgets', function (Blueprint $table) {
                $table->decimal('percentage_used', 5, 2)->default(0)->after('amount_used');
            });
        }

        if (!Schema::hasColumn('budgets', 'category')) {
            Schema::table('budgets', function (Blueprint $table) {
                $table->string('category')->nullable()->after('title');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('budgets', 'amount_used')) {
            Schema::table('budgets', function (Blueprint $table) {
                $table->dropColumn('amount_used');
            });
        }

        if (Schema::hasColumn('budgets', 'percentage_used')) {
            Schema::table('budgets', function (Blueprint $table) {
                $table->dropColumn('percentage_used');
            });
        }

        if (Schema::hasColumn('budgets', 'category')) {
            Schema::table('budgets', function (Blueprint $table) {
                $table->dropColumn('category');
            });
        }
    }
};
