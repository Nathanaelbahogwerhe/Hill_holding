<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Budgets
        if (!Schema::hasColumn('budgets', 'attachment')) {
            Schema::table('budgets', function (Blueprint $table) {
                $table->string('attachment')->nullable()->after('status');
            });
        }

        // Expenses
        if (!Schema::hasColumn('expenses', 'attachment')) {
            Schema::table('expenses', function (Blueprint $table) {
                $table->string('attachment')->nullable()->after('agence_id');
            });
        }

        // Revenues
        if (!Schema::hasColumn('revenues', 'attachment')) {
            Schema::table('revenues', function (Blueprint $table) {
                $table->string('attachment')->nullable()->after('agence_id');
            });
        }

        // Invoices
        if (!Schema::hasColumn('invoices', 'attachment')) {
            Schema::table('invoices', function (Blueprint $table) {
                $table->string('attachment')->nullable()->after('status');
            });
        }

        // Transactions
        if (!Schema::hasColumn('transactions', 'attachment')) {
            Schema::table('transactions', function (Blueprint $table) {
                $table->string('attachment')->nullable()->after('user_id');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('budgets', 'attachment')) {
            Schema::table('budgets', function (Blueprint $table) {
                $table->dropColumn('attachment');
            });
        }

        if (Schema::hasColumn('expenses', 'attachment')) {
            Schema::table('expenses', function (Blueprint $table) {
                $table->dropColumn('attachment');
            });
        }

        if (Schema::hasColumn('revenues', 'attachment')) {
            Schema::table('revenues', function (Blueprint $table) {
                $table->dropColumn('attachment');
            });
        }

        if (Schema::hasColumn('invoices', 'attachment')) {
            Schema::table('invoices', function (Blueprint $table) {
                $table->dropColumn('attachment');
            });
        }

        if (Schema::hasColumn('transactions', 'attachment')) {
            Schema::table('transactions', function (Blueprint $table) {
                $table->dropColumn('attachment');
            });
        }
    }
};
