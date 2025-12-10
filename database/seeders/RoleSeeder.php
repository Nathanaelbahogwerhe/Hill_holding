<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Role::query()->delete();
        Permission::query()->delete();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // ðŸ”¹ DÃ©finition des rÃ´les
        $roles = [
            'Super Admin',
            'HR Manager',
            'Finance Manager',
            'Operations Manager',
            'Employee',
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role, 'guard_name' => 'web']);
        }

        // ðŸ”¹ Toutes les permissions regroupÃ©es
        $permissions = [

            // HR
            'view employees', 'create employees', 'edit employees', 'delete employees',
            'view departments', 'create departments', 'edit departments', 'delete departments',
            'view leaves', 'create leaves', 'edit leaves', 'delete leaves',
            'approve leaves', 'reject leaves',
            'view payrolls', 'generate payrolls', 'edit payrolls',

            // Finance
            'view transactions', 'create transactions', 'edit transactions', 'delete transactions',
            'view expenses', 'create expenses', 'edit expenses', 'delete expenses',
            'view revenues', 'create revenues', 'edit revenues', 'delete revenues',
            'view budgets', 'create budgets', 'edit budgets', 'delete budgets',
            'view financial reports', 'generate reports',

            // OpÃ©rations
            'view clients', 'create clients', 'edit clients', 'delete clients',
            'view projects', 'create projects', 'edit projects', 'delete projects',
            'view tasks', 'create tasks', 'edit tasks', 'delete tasks',
            'view contracts', 'create contracts', 'edit contracts', 'delete contracts',

            // SystÃ¨me
            'view assets', 'edit settings',
            'view notifications', 'mark notifications as read',
        ];

        // ðŸ”¸ CrÃ©ation effective avant assignation
        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm, 'guard_name' => 'web']);
        }

        // ðŸ”’ Attribution des permissions aux rÃ´les
        $superAdmin = Role::where('name', 'Super Admin')->first();
        $superAdmin->givePermissionTo(Permission::all());

        $rh = Role::where('name', 'HR Manager')->first();
        $rh->givePermissionTo([
            'view employees', 'create employees', 'edit employees', 'delete employees',
            'view departments', 'create departments', 'edit departments', 'delete departments',
            'view leaves', 'create leaves', 'edit leaves', 'delete leaves',
            'approve leaves', 'reject leaves',
            'view payrolls', 'generate payrolls', 'edit payrolls',
            'view notifications', 'mark notifications as read',
        ]);

        $finance = Role::where('name', 'Finance Manager')->first();
        $finance->givePermissionTo([
            'view transactions', 'create transactions', 'edit transactions', 'delete transactions',
            'view expenses', 'create expenses', 'edit expenses', 'delete expenses',
            'view revenues', 'create revenues', 'edit revenues', 'delete revenues',
            'view budgets', 'create budgets', 'edit budgets', 'delete budgets',
            'view financial reports', 'generate reports',
            'view notifications', 'mark notifications as read',
        ]);

        $ops = Role::where('name', 'Operations Manager')->first();
        $ops->givePermissionTo([
            'view clients', 'create clients', 'edit clients', 'delete clients',
            'view projects', 'create projects', 'edit projects', 'delete projects',
            'view tasks', 'create tasks', 'edit tasks', 'delete tasks',
            'view contracts', 'create contracts', 'edit contracts', 'delete contracts',
            'view notifications', 'mark notifications as read',
        ]);

        $employee = Role::where('name', 'Employee')->first();
        $employee->givePermissionTo([
            'view employees',
            'view leaves', 'create leaves',
            'view payrolls',
            'view notifications', 'mark notifications as read',
        ]);

        $this->command->info('âœ… Tous les rÃ´les et permissions ont Ã©tÃ© recrÃ©Ã©s avec succÃ¨s.');
    }
}







