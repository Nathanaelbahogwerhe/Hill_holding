<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // --- 1) Structure d’organisation ---
        $this->call([
            HillHoldingSeeder::class,
            FilialeSeeder::class,
            AgenceSeeder::class,
        ]);

        // --- 2) Rôles & permissions ---
        $this->call(RoleSeeder::class);
        // $this->call(RolesAndPermissionsSeeder::class);

        // --- 3) Super Admin ---
        $superAdmin = User::firstOrCreate(
            ['email' => 'admin@hillholding.bi'],
            [
                'name' => 'Super Admin',
                'password' => bcrypt('password123'),
            ]
        );
        $superAdmin->assignRole('Super Admin');
        $this->command->warn('âš¡ Super Admin : admin@hillholding.bi / password123');

        // --- 4) Utilisateurs par rôle ---
        $users = [
            [
                'name' => 'HR Manager',
                'email' => 'hr@hillholding.bi',
                'role' => 'HR Manager',
            ],
            [
                'name' => 'Finance Manager',
                'email' => 'finance@hillholding.bi',
                'role' => 'Finance Manager',
            ],
            [
                'name' => 'Operations Manager',
                'email' => 'ops@hillholding.bi',
                'role' => 'Operations Manager',
            ],
            [
                'name' => 'Employee User',
                'email' => 'employee@hillholding.bi',
                'role' => 'Employee',
            ],
        ];

        foreach ($users as $data) {
            $user = User::firstOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'password' => bcrypt('password123'),
                ]
            );
            if (!$user->hasRole($data['role'])) {
                $user->assignRole($data['role']);
            }
            $this->command->info("ðŸ‘¤ {$data['role']} créé : {$data['email']} / password123");
        }

        // --- 5) Autres seeders de données ---
        $this->call([
            CentralizedSeeder::class,
            UserSeeder::class,

            // Données RH
            EmployeeSeeder::class,
            DepartmentSeeder::class,
            TestEmployeeSeeder::class,
            LeaveTypeSeeder::class,
            LeaveSeeder::class,
            PayrollSeeder::class,
            InsurancePlanSeeder::class,
            EmployeeInsuranceSeeder::class,

            // Actifs & finances
            AssetSeeder::class,
            TransactionSeeder::class,
            ExpenseSeeder::class,
            RevenueSeeder::class,
            BudgetSeeder::class,

            // CRM & facturation
            ClientSeeder::class,
            InvoiceSeeder::class,
            ClientInvoiceSeeder::class,

            // Messagerie
            MessageSeeder::class,

            // Projets & tâches
            ProjectSeeder::class,
            TaskSeeder::class,
        ]);
    }
}







