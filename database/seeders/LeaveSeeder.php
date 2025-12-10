<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Leave;
use App\Models\Employee;
use App\Models\LeaveType;

class LeaveSeeder extends Seeder
{
    public function run(): void
    {
        $employees = Employee::all();
        $leaveTypes = LeaveType::all();

        foreach ($employees as $employee) {
            foreach ($leaveTypes as $type) {
                Leave::updateOrCreate([
                    'employee_id' => $employee->id,
                    'leave_type_id' => $type->id
                ], [
                    'start_date' => now(),
                    'end_date' => now()->addDays($type->days),
                    'status' => 'pending'
                ]);
            }
        }
    }
}







