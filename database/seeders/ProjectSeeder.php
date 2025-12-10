<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Project;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        // CrÃ©ons 5 projets fictifs
        $projects = [
            ['name' => 'Site web corporate', 'description' => 'DÃ©veloppement du nouveau site HillHolding', 'status' => 'in_progress'],
            ['name' => 'Application mobile', 'description' => 'App mobile pour les employÃ©s', 'status' => 'pending'],
            ['name' => 'Migration serveur', 'description' => 'Migration vers serveur cloud', 'status' => 'completed'],
            ['name' => 'Campagne marketing', 'description' => 'Campagne digitale pour filiales', 'status' => 'in_progress'],
            ['name' => 'Audit interne', 'description' => 'Audit complet des dÃ©partements', 'status' => 'pending'],
        ];

        foreach ($projects as $project) {
            Project::create($project);
        }
    }
}







