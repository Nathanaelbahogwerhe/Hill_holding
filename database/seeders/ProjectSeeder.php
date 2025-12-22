<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Project;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        // Créons 5 projets fictifs
        $projects = [
            ['name' => 'Site web corporate', 'description' => 'Développement du nouveau site HillHolding', 'status' => 'in_progress'],
            ['name' => 'Application mobile', 'description' => 'App mobile pour les employés', 'status' => 'pending'],
            ['name' => 'Migration serveur', 'description' => 'Migration vers serveur cloud', 'status' => 'completed'],
            ['name' => 'Campagne marketing', 'description' => 'Campagne digitale pour filiales', 'status' => 'in_progress'],
            ['name' => 'Audit interne', 'description' => 'Audit complet des départements', 'status' => 'pending'],
        ];

        foreach ($projects as $project) {
            Project::create($project);
        }
    }
}







