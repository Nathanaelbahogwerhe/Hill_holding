<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Filiale;
use App\Models\Agence;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Récupération des rôles
        $superAdminRole = Role::where('name', 'Super Admin')->first();
        $rhRole         = Role::where('name', 'RH Manager')->first();
        $financeRole    = Role::where('name', 'Finance Manager')->first();
        $opsRole        = Role::where('name', 'Operations Manager')->first();
        $employeeRole   = Role::where('name', 'Employee')->first();

        // Maison mère
        $superAdmin = User::updateOrCreate(
            ['email' => 'admin@hillholding.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password'),
                'filiale_id' => null,
                'agence_id' => null,
            ]
        );
        $superAdmin->assignRole($superAdminRole);

        // RH Burundi
        $filialeBI = Filiale::where('code', 'HH-BI')->first();
        $agenceBI1 = Agence::where('code', 'AG-BI-01')->first();

        $rhBurundi = User::updateOrCreate(
            ['email' => 'rh.bi@hillholding.com'],
            [
                'name' => 'RH Burundi',
                'password' => Hash::make('password'),
                'filiale_id' => $filialeBI->id,
                'agence_id' => $agenceBI1->id,
            ]
        );
        $rhBurundi->assignRole($rhRole);

        // Finance Rwanda
        $filialeRW = Filiale::where('code', 'HH-RW')->first();
        $agenceRW1 = Agence::where('code', 'AG-RW-01')->first();

        $financeRwanda = User::updateOrCreate(
            ['email' => 'finance.rw@hillholding.com'],
            [
                'name' => 'Finance Rwanda',
                'password' => Hash::make('password'),
                'filiale_id' => $filialeRW->id,
                'agence_id' => $agenceRW1->id,
            ]
        );
        $financeRwanda->assignRole($financeRole);

        // Opérations RDC
        $filialeRDC = Filiale::where('code', 'HH-RDC')->first();
        $agenceRDC1 = Agence::where('code', 'AG-RDC-01')->first();

        $opsRDC = User::updateOrCreate(
            ['email' => 'ops.rdc@hillholding.com'],
            [
                'name' => 'Operations RDC',
                'password' => Hash::make('password'),
                'filiale_id' => $filialeRDC->id,
                'agence_id' => $agenceRDC1->id,
            ]
        );
        $opsRDC->assignRole($opsRole);

        // Employé standard Goma
        $agenceGoma = Agence::where('code', 'AG-RDC-02')->first();

        $employeeGoma = User::updateOrCreate(
            ['email' => 'employe.goma@hillholding.com'],
            [
                'name' => 'Employé Goma',
                'password' => Hash::make('password'),
                'filiale_id' => $filialeRDC->id,
                'agence_id' => $agenceGoma->id,
            ]
        );
        $employeeGoma->assignRole($employeeRole);
    }
}







