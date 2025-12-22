<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            if (!Schema::hasColumn('employees', 'date_of_birth')) {
                $table->date('date_of_birth')->nullable()->after('last_name');
            }
            if (!Schema::hasColumn('employees', 'place_of_birth')) {
                $table->string('place_of_birth')->nullable()->after('date_of_birth');
            }
            if (!Schema::hasColumn('employees', 'nationality')) {
                $table->string('nationality')->nullable()->after('place_of_birth');
            }
            if (!Schema::hasColumn('employees', 'id_document_type')) {
                $table->string('id_document_type')->nullable()->after('nationality');
            }
            if (!Schema::hasColumn('employees', 'id_document_number')) {
                $table->string('id_document_number')->nullable()->after('id_document_type');
            }
            if (!Schema::hasColumn('employees', 'id_document_file')) {
                $table->string('id_document_file')->nullable()->after('id_document_number');
            }

            // Contact & localisation
            if (!Schema::hasColumn('employees', 'address')) {
                $table->text('address')->nullable()->after('id_document_file');
            }
            if (!Schema::hasColumn('employees', 'phone')) {
                $table->string('phone')->nullable()->after('address');
            }
            if (!Schema::hasColumn('employees', 'personal_email')) {
                $table->string('personal_email')->nullable()->after('phone');
            }
            if (!Schema::hasColumn('employees', 'emergency_contact_name')) {
                $table->string('emergency_contact_name')->nullable()->after('personal_email');
            }
            if (!Schema::hasColumn('employees', 'emergency_contact_phone')) {
                $table->string('emergency_contact_phone')->nullable()->after('emergency_contact_name');
            }

            // Administrative & bank
            if (!Schema::hasColumn('employees', 'matricule')) {
                $table->string('matricule')->nullable()->unique()->after('emergency_contact_phone');
            }
            if (!Schema::hasColumn('employees', 'inss_number')) {
                $table->string('inss_number')->nullable()->after('matricule');
            }
            if (!Schema::hasColumn('employees', 'nif')) {
                $table->string('nif')->nullable()->after('inss_number');
            }
            if (!Schema::hasColumn('employees', 'rib')) {
                $table->string('rib')->nullable()->after('nif');
            }

            // Contractual
            if (!Schema::hasColumn('employees', 'contract_type')) {
                $table->string('contract_type')->nullable()->after('rib');
            }
            if (!Schema::hasColumn('employees', 'hire_date')) {
                $table->date('hire_date')->nullable()->after('contract_type');
            }
            if (!Schema::hasColumn('employees', 'workplace')) {
                $table->string('workplace')->nullable()->after('hire_date');
            }
            if (!Schema::hasColumn('employees', 'qualifications')) {
                $table->text('qualifications')->nullable()->after('workplace');
            }

            // Family & salary extras
            if (!Schema::hasColumn('employees', 'marital_status')) {
                $table->string('marital_status')->nullable()->after('qualifications');
            }
            if (!Schema::hasColumn('employees', 'children_count')) {
                $table->unsignedInteger('children_count')->nullable()->after('marital_status');
            }
            if (!Schema::hasColumn('employees', 'salary_allowances')) {
                $table->decimal('salary_allowances', 15, 2)->nullable()->after('children_count');
            }
        });
    }

    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            $cols = [
                'date_of_birth','place_of_birth','nationality','id_document_type','id_document_number','id_document_file',
                'address','phone','personal_email','emergency_contact_name','emergency_contact_phone',
                'matricule','inss_number','nif','rib',
                'contract_type','hire_date','workplace','qualifications',
                'marital_status','children_count','salary_allowances'
            ];
            foreach ($cols as $col) {
                if (Schema::hasColumn('employees', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
