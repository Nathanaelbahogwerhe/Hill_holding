<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Employees: migrate attachment to attachments
        if (Schema::hasColumn('employees', 'attachment')) {
            // Backup old data
            $employees = DB::table('employees')->whereNotNull('attachment')->get();
            
            // Add new JSON column
            Schema::table('employees', function (Blueprint $table) {
                $table->json('attachments')->nullable()->after('attachment');
            });
            
            // Migrate data from attachment to attachments with metadata structure
            foreach ($employees as $employee) {
                if ($employee->attachment) {
                    $attachments = [[
                        'original_name' => basename($employee->attachment),
                        'filename' => basename($employee->attachment),
                        'path' => $employee->attachment,
                        'url' => '/storage/' . $employee->attachment,
                        'size' => file_exists(storage_path('app/public/' . $employee->attachment)) 
                            ? filesize(storage_path('app/public/' . $employee->attachment)) 
                            : 0,
                        'mime_type' => 'application/octet-stream',
                        'uploaded_at' => now()->toDateTimeString(),
                    ]];
                    
                    DB::table('employees')
                        ->where('id', $employee->id)
                        ->update(['attachments' => json_encode($attachments)]);
                }
            }
            
            // Drop old column
            Schema::table('employees', function (Blueprint $table) {
                $table->dropColumn('attachment');
            });
        }

        // Contracts: migrate attachment to attachments
        if (Schema::hasColumn('contracts', 'attachment')) {
            $contracts = DB::table('contracts')->whereNotNull('attachment')->get();
            
            Schema::table('contracts', function (Blueprint $table) {
                $table->json('attachments')->nullable()->after('attachment');
            });
            
            foreach ($contracts as $contract) {
                if ($contract->attachment) {
                    $attachments = [[
                        'original_name' => basename($contract->attachment),
                        'filename' => basename($contract->attachment),
                        'path' => $contract->attachment,
                        'url' => '/storage/' . $contract->attachment,
                        'size' => file_exists(storage_path('app/public/' . $contract->attachment)) 
                            ? filesize(storage_path('app/public/' . $contract->attachment)) 
                            : 0,
                        'mime_type' => 'application/octet-stream',
                        'uploaded_at' => now()->toDateTimeString(),
                    ]];
                    
                    DB::table('contracts')
                        ->where('id', $contract->id)
                        ->update(['attachments' => json_encode($attachments)]);
                }
            }
            
            Schema::table('contracts', function (Blueprint $table) {
                $table->dropColumn('attachment');
            });
        }

        // Payrolls: migrate attachment to attachments
        if (Schema::hasColumn('payrolls', 'attachment')) {
            $payrolls = DB::table('payrolls')->whereNotNull('attachment')->get();
            
            Schema::table('payrolls', function (Blueprint $table) {
                $table->json('attachments')->nullable()->after('attachment');
            });
            
            foreach ($payrolls as $payroll) {
                if ($payroll->attachment) {
                    $attachments = [[
                        'original_name' => basename($payroll->attachment),
                        'filename' => basename($payroll->attachment),
                        'path' => $payroll->attachment,
                        'url' => '/storage/' . $payroll->attachment,
                        'size' => file_exists(storage_path('app/public/' . $payroll->attachment)) 
                            ? filesize(storage_path('app/public/' . $payroll->attachment)) 
                            : 0,
                        'mime_type' => 'application/octet-stream',
                        'uploaded_at' => now()->toDateTimeString(),
                    ]];
                    
                    DB::table('payrolls')
                        ->where('id', $payroll->id)
                        ->update(['attachments' => json_encode($attachments)]);
                }
            }
            
            Schema::table('payrolls', function (Blueprint $table) {
                $table->dropColumn('attachment');
            });
        }

        // Leaves: migrate attachment to attachments
        if (Schema::hasColumn('leaves', 'attachment')) {
            $leaves = DB::table('leaves')->whereNotNull('attachment')->get();
            
            Schema::table('leaves', function (Blueprint $table) {
                $table->json('attachments')->nullable()->after('attachment');
            });
            
            foreach ($leaves as $leave) {
                if ($leave->attachment) {
                    $attachments = [[
                        'original_name' => basename($leave->attachment),
                        'filename' => basename($leave->attachment),
                        'path' => $leave->attachment,
                        'url' => '/storage/' . $leave->attachment,
                        'size' => file_exists(storage_path('app/public/' . $leave->attachment)) 
                            ? filesize(storage_path('app/public/' . $leave->attachment)) 
                            : 0,
                        'mime_type' => 'application/octet-stream',
                        'uploaded_at' => now()->toDateTimeString(),
                    ]];
                    
                    DB::table('leaves')
                        ->where('id', $leave->id)
                        ->update(['attachments' => json_encode($attachments)]);
                }
            }
            
            Schema::table('leaves', function (Blueprint $table) {
                $table->dropColumn('attachment');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Employees
        if (Schema::hasColumn('employees', 'attachments')) {
            $employees = DB::table('employees')->whereNotNull('attachments')->get();
            
            Schema::table('employees', function (Blueprint $table) {
                $table->string('attachment')->nullable()->after('basic_salary');
            });
            
            foreach ($employees as $employee) {
                if ($employee->attachments) {
                    $attachments = json_decode($employee->attachments, true);
                    if (!empty($attachments) && isset($attachments[0]['path'])) {
                        DB::table('employees')
                            ->where('id', $employee->id)
                            ->update(['attachment' => $attachments[0]['path']]);
                    }
                }
            }
            
            Schema::table('employees', function (Blueprint $table) {
                $table->dropColumn('attachments');
            });
        }

        // Contracts
        if (Schema::hasColumn('contracts', 'attachments')) {
            $contracts = DB::table('contracts')->whereNotNull('attachments')->get();
            
            Schema::table('contracts', function (Blueprint $table) {
                $table->string('attachment')->nullable();
            });
            
            foreach ($contracts as $contract) {
                if ($contract->attachments) {
                    $attachments = json_decode($contract->attachments, true);
                    if (!empty($attachments) && isset($attachments[0]['path'])) {
                        DB::table('contracts')
                            ->where('id', $contract->id)
                            ->update(['attachment' => $attachments[0]['path']]);
                    }
                }
            }
            
            Schema::table('contracts', function (Blueprint $table) {
                $table->dropColumn('attachments');
            });
        }

        // Payrolls
        if (Schema::hasColumn('payrolls', 'attachments')) {
            $payrolls = DB::table('payrolls')->whereNotNull('attachments')->get();
            
            Schema::table('payrolls', function (Blueprint $table) {
                $table->string('attachment')->nullable();
            });
            
            foreach ($payrolls as $payroll) {
                if ($payroll->attachments) {
                    $attachments = json_decode($payroll->attachments, true);
                    if (!empty($attachments) && isset($attachments[0]['path'])) {
                        DB::table('payrolls')
                            ->where('id', $payroll->id)
                            ->update(['attachment' => $attachments[0]['path']]);
                    }
                }
            }
            
            Schema::table('payrolls', function (Blueprint $table) {
                $table->dropColumn('attachments');
            });
        }

        // Leaves
        if (Schema::hasColumn('leaves', 'attachments')) {
            $leaves = DB::table('leaves')->whereNotNull('attachments')->get();
            
            Schema::table('leaves', function (Blueprint $table) {
                $table->string('attachment')->nullable();
            });
            
            foreach ($leaves as $leave) {
                if ($leave->attachments) {
                    $attachments = json_decode($leave->attachments, true);
                    if (!empty($attachments) && isset($attachments[0]['path'])) {
                        DB::table('leaves')
                            ->where('id', $leave->id)
                            ->update(['attachment' => $attachments[0]['path']]);
                    }
                }
            }
            
            Schema::table('leaves', function (Blueprint $table) {
                $table->dropColumn('attachments');
            });
        }
    }
};
