<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('payrolls', 'attachment')) {
            Schema::table('payrolls', function (Blueprint $table) {
                $table->string('attachment')->nullable()->after('net_salary');
            });
        }

        if (!Schema::hasColumn('leaves', 'attachment')) {
            Schema::table('leaves', function (Blueprint $table) {
                $table->string('attachment')->nullable()->after('status');
            });
        }

        if (!Schema::hasColumn('contracts', 'attachment')) {
            Schema::table('contracts', function (Blueprint $table) {
                $table->string('attachment')->nullable()->after('salary');
            });
        }

        if (!Schema::hasColumn('attendances', 'attachment')) {
            Schema::table('attendances', function (Blueprint $table) {
                $table->string('attachment')->nullable()->after('status');
            });
        }

        if (!Schema::hasColumn('leave_types', 'attachment')) {
            Schema::table('leave_types', function (Blueprint $table) {
                $table->string('attachment')->nullable();
            });
        }
    }

    public function down(): void
    {
        Schema::table('payrolls', function (Blueprint $table) {
            $table->dropColumn('attachment');
        });

        Schema::table('leaves', function (Blueprint $table) {
            $table->dropColumn('attachment');
        });

        Schema::table('contracts', function (Blueprint $table) {
            $table->dropColumn('attachment');
        });

        Schema::table('attendances', function (Blueprint $table) {
            $table->dropColumn('attachment');
        });

        Schema::table('leave_types', function (Blueprint $table) {
            $table->dropColumn('attachment');
        });
    }
};
