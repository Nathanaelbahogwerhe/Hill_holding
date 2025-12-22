<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Création de l'utilisateur Super Admin
        $superAdmin = User::firstOrCreate(
            ['email' => 'admin@hillholding.bi'],
            [
                'name' => 'Super Admin',
                'password' => bcrypt('password123'),
            ]
        );

        // Assigner le rôle "Super Admin"
        $superAdmin->assignRole('Super Admin');

        $this->command->warn('âš¡ Super Admin créé : admin@hillholding.bi / password123');
    }
}







