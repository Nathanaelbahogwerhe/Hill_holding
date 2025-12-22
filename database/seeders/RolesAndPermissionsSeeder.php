<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // 🟡 Désactiver temporairement les contraintes de clé étrangère
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // 🔹 Supprimer les permissions et rôles existants
        Permission::truncate();
        Role::truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // 🔹 Vider le cache de Spatie
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // -------------------------
        // 1️⃣ Créer les permissions
        // -------------------------
        $permissions = [
            // RH
            'view_employees','create_employees','edit_employees','delete_employees',
            'view_departments','create_departments','edit_departments','delete_departments',
            'view_users','create_users','edit_users','delete_users',
            'view_filiales','create_filiales','edit_filiales','delete_filiales',
            'view_agences','create_agences','edit_agences','delete_agences',
            'view_payrolls','create_payrolls','edit_payrolls','delete_payrolls',
            'view_leaves','approve_leaves','reject_leaves','create_leaves','edit_leaves','delete_leaves',
            'view_leave_types','create_leave_types','edit_leave_types','delete_leave_types',
            'view_insurances','create_insurances','edit_insurances','delete_insurances',
            'view_contracts','create_contracts','edit_contracts','delete_contracts',
            'view_positions','create_positions','edit_positions','delete_positions',
            'view_attendances','create_attendances','edit_attendances','delete_attendances',

            // Business
            'view_clients','create_clients','edit_clients','delete_clients',
            'view_projects','create_projects','edit_projects','delete_projects',
            'view_tasks','create_tasks','edit_tasks','delete_tasks',
            'view_client_payments','create_client_payments','edit_client_payments','delete_client_payments',
            'view_products','create_products','edit_products','delete_products',
            'view_stock_transfers','create_stock_transfers','edit_stock_transfers','delete_stock_transfers',
            'view_contracts_business','create_contracts_business','edit_contracts_business','delete_contracts_business',

            // Finance
            'view_transactions','create_transactions','edit_transactions','delete_transactions',
            'view_expenses','create_expenses','edit_expenses','delete_expenses',
            'view_revenues','create_revenues','edit_revenues','delete_revenues',
            'view_financial_reports','create_financial_reports','edit_financial_reports','delete_financial_reports',
            'view_finances','create_finances','edit_finances','delete_finances',
            'view_budgets','create_budgets','edit_budgets','delete_budgets',
            'view_invoices','create_invoices','edit_invoices','delete_invoices',

            // Roles & Permissions
            'manage_roles','manage_permissions',

            // Messages / Assets / Settings
            'view_messages','reply_messages','view_assets','view_settings',

            // Profil
            'edit_profile',
        ];

        foreach ($permissions as $perm) {
            Permission::create(['name' => $perm]);
        }

        // -------------------------
        // 2️⃣ Créer les rôles
        // -------------------------
        $roles = [
            'Super Admin' => Permission::all(),

            // Pour filiale
            'RH Manager' => Permission::where('name','like','%employees%')
                                ->orWhere('name','like','%departments%')
                                ->orWhere('name','like','%users%')
                                ->orWhere('name','like','%filiales%')
                                ->orWhere('name','like','%agences%')
                                ->orWhere('name','like','%payrolls%')
                                ->orWhere('name','like','%leaves%')
                                ->orWhere('name','like','%leave_types%')
                                ->orWhere('name','like','%insurances%')
                                ->orWhere('name','like','%contracts%')
                                ->orWhere('name','like','%positions%')
                                ->orWhere('name','like','%attendances%')
                                ->get(),

            'Finance Manager' => Permission::where('name','like','%transactions%')
                                ->orWhere('name','like','%expenses%')
                                ->orWhere('name','like','%revenues%')
                                ->orWhere('name','like','%financial_reports%')
                                ->orWhere('name','like','%finances%')
                                ->orWhere('name','like','%budgets%')
                                ->orWhere('name','like','%invoices%')
                                ->get(),

            'Operations Manager' => Permission::where('name','like','%clients%')
                                ->orWhere('name','like','%projects%')
                                ->orWhere('name','like','%tasks%')
                                ->orWhere('name','like','%client_payments%')
                                ->orWhere('name','like','%products%')
                                ->orWhere('name','like','%stock_transfers%')
                                ->orWhere('name','like','%contracts_business%')
                                ->get(),

            // Pour agence
            'Employee' => Permission::where('name','like','%edit_profile%')->get(),
        ];

        foreach ($roles as $roleName => $rolePermissions) {
            $role = Role::create(['name' => $roleName]);
            $role->syncPermissions($rolePermissions);
        }

        // -------------------------
        // 3️⃣ Créer utilisateurs de test pour la maison mère
        // -------------------------
        $users = [
            ['name'=>'Super Admin','email'=>'admin@hillholding.bi','password'=>bcrypt('password123'),'role'=>'Super Admin'],
            ['name'=>'HR Manager','email'=>'rh@hillholding.bi','password'=>bcrypt('password123'),'role'=>'HR Manager'],
            ['name'=>'Finance Manager','email'=>'finance@hillholding.bi','password'=>bcrypt('password123'),'role'=>'Finance Manager'],
            ['name'=>'Operations Manager','email'=>'ops@hillholding.bi','password'=>bcrypt('password123'),'role'=>'Operations Manager'],
            ['name'=>'Employee','email'=>'employee@hillholding.bi','password'=>bcrypt('password123'),'role'=>'Employee'],
        ];

        foreach ($users as $u) {
            $user = User::updateOrCreate(
                ['email'=>$u['email']],
                ['name'=>$u['name'],'password'=>$u['password']]
            );
            $user->assignRole($u['role']);
        }

        $this->command->info("✅ Rôles, permissions et utilisateurs de test créés avec succès !");
    }
}
