<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // CrÃ©ation de l'utilisateur Super Admin
        $superAdmin = User::firstOrCreate(
            ['email' => 'admin@hillholding.bi'],
            [
                'name' => 'Super Admin',
                'password' => bcrypt('password123'),
            ]
        );

        // Assigner le rÃ´le "Super Admin"
        $superAdmin->assignRole('Super Admin');

        $this->command->warn('âš¡ Super Admin crÃ©Ã© : admin@hillholding.bi / password123');
    }
}







