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

        // 🔹 Définition des rôles
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

        // 🔹 Toutes les permissions regroupées
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

            // Opérations
            'view clients', 'create clients', 'edit clients', 'delete clients',
            'view projects', 'create projects', 'edit projects', 'delete projects',
            'view tasks', 'create tasks', 'edit tasks', 'delete tasks',
            'view contracts', 'create contracts', 'edit contracts', 'delete contracts',

            // Système
            'view assets', 'edit settings',
            'view notifications', 'mark notifications as read',
        ];

        // 🔸 Création effective avant assignation
        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm, 'guard_name' => 'web']);
        }

        // 🔒 Attribution des permissions aux rôles
        $superAdmin = Role::where('name', 'Super Admin')->first();
        $superAdmin->givePermissionTo(Permission::all());

        $hr = Role::where('name', 'HR Manager')->first();
        $hr->givePermissionTo([
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

        $this->command->info('✅ Tous les rôles et permissions ont été recréés avec succès.');
    }
}




