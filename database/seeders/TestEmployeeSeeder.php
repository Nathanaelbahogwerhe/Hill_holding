<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Filiale;
use App\Models\Agence;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class TestEmployeeSeeder extends Seeder
{
    public function run(): void
    {
        // Récupérer une filiale et une agence existante pour les lier aux utilisateurs
        $filiale = Filiale::first(); // ou Filiale::where('code', 'HH-BI')->first();
        $agence = Agence::first();   // ou Agence::where('code', 'HH-BI-BUJ')->first();

        if (!$filiale || !$agence) {
            $this->command->warn("âŒ Filiale ou agence introuvable. TestEmployeeSeeder annulé.");
            return;
        }

        // Exemple de création de 5 employés fictifs
        for ($i = 1; $i <= 5; $i++) {
            $user = User::updateOrCreate(
                ['email' => "test.employee{$i}@HillHolding.com"],
                [
                    'name' => "Test Employee {$i}",
                    'password' => Hash::make('password'),
                    'filiale_id' => $filiale->id,
                    'agence_id' => $agence->id,
                ]
            );
            // Assigner le rôle Employee
            $user->assignRole('Employee');
        }

        $this->command->info("âœ… TestEmployeeSeeder : 5 employés de test créés avec succès !");
    }
}







