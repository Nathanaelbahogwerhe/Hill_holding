<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Employee;
use App\Models\Department;
use App\Models\Filiale;
use App\Models\Agence;

class EmployeeSeeder extends Seeder
{
    public function run(): void
    {
        // Exemple : récupérons un département pour associer les employés
        $department = Department::first() ?? Department::create(['name' => 'Général']);

        // Récupérons une filiale et une agence existante
        $filiale = Filiale::first();
        $agence  = Agence::first();

        // 1) Employé HillHolding (pas de filiale, pas d’agence)
        Employee::updateOrCreate(
            ['email' => 'alice@hillholding.com'],
            [
                'first_name'    => 'Alice',
                'last_name'     => 'Niyonzima',
                'department_id' => $department->id,
                'filiale_id'    => null,
                'agency_id'     => null,
            ]
        );

        // 2) Employé Filiale (lié uniquement à  une filiale)
        if ($filiale) {
            Employee::updateOrCreate(
                ['email' => 'jean@' . strtolower($filiale->name) . '.com'],
                [
                    'first_name'    => 'Jean',
                    'last_name'     => 'Habonimana',
                    'department_id' => $department->id,
                    'filiale_id'    => $filiale->id,
                    'agency_id'     => null,
                ]
            );
        }

        // 3) Employé Agence (lié à  une filiale ET une agence)
        if ($filiale && $agence) {
            Employee::updateOrCreate(
                ['email' => 'eric@' . strtolower($agence->name) . '.com'],
                [
                    'first_name'    => 'Eric',
                    'last_name'     => 'Hakizimana',
                    'department_id' => $department->id,
                    'filiale_id'    => $filiale->id,
                    'agency_id'     => $agence->id,
                ]
            );
        }

        $this->command->info('ðŸ‘¥ Employés de test créés avec succès.');
    }
}







