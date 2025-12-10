<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Payroll;
use App\Models\Employee;

class PayrollSeeder extends Seeder
{
    public function run(): void
    {
        $employees = Employee::all();

        foreach ($employees as $employee) {
            $basicSalary = rand(300000, 800000); // salaire de base alÃ©atoire en FBu
            $bonus       = rand(20000, 150000);
            $deductions  = rand(10000, 100000);
            $netSalary   = $basicSalary + $bonus - $deductions;

            Payroll::updateOrCreate(
                [
                    'employee_id' => $employee->id,
                    'month'       => now()->format('Y-m'),
                ],
                [
                    'basic_salary' => $basicSalary,
                    'bonus'        => $bonus,
                    'deductions'   => $deductions,
                    'net_salary'   => $netSalary,
                ]
            );
        }

        $this->command->info('ðŸ’° Fiches de paie gÃ©nÃ©rÃ©es avec succÃ¨s.');
    }
}







