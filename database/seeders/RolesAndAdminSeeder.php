<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndAdminSeeder extends Seeder
{
    public function run(): void
    {
        // âœ… Création des rôles
        $adminRole = Role::firstOrCreate(['name' => 'Admin']);
        $superAdminRole = Role::firstOrCreate(['name' => 'Super Admin']);

        // âœ… Création de permissions globales (facultatif)
        $permissions = [
            'manage users',
            'manage roles',
            'manage payroll',
            'manage leaves',
            'manage agencies'
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm]);
        }

        // Assigner toutes les permissions au Super Admin
        $superAdminRole->syncPermissions(Permission::all());

        // âœ… Création de l’utilisateur Super Admin
        $superAdminEmail = 'superadmin@example.com';
        $superAdmin = User::firstOrCreate(
            ['email' => $superAdminEmail],
            [
                'name' => 'Super Admin',
                'password' => bcrypt('password123'), // change après
            ]
        );

        // Assigner le rôle Super Admin
        if (!$superAdmin->hasRole('Super Admin')) {
            $superAdmin->assignRole($superAdminRole);
        }

        $this->command->info('Super Admin créé avec succès : ' . $superAdminEmail . ' / password123');
    }
}







