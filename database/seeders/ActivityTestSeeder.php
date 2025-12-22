<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Activity;
use App\Models\User;
use App\Models\Employee;
use App\Models\Department;
use App\Models\Filiale;
use App\Models\Agence;
use App\Models\Project;
use Carbon\Carbon;

class ActivityTestSeeder extends Seeder
{
    public function run(): void
    {
        // Récupérer des données existantes
        $users = User::all();
        $employees = Employee::all();
        $departments = Department::all();
        $filiale = Filiale::first();
        $agence = Agence::first();
        $project = Project::first();
        
        if ($users->isEmpty() || $employees->isEmpty() || $departments->isEmpty()) {
            $this->command->error('Veuillez d\'abord créer des utilisateurs, employés et départements.');
            return;
        }

        $this->command->info('Création de 15 activités de test avec relations RH...');

        $types = ['réunion', 'formation', 'mission', 'événement', 'autre'];
        $statuts = ['planifiée', 'en_cours', 'terminée'];
        $mois = range(1, 12);

        $activities = [
            ['titre' => 'Réunion d\'équipe mensuelle', 'type' => 'réunion', 'lieu' => 'Salle A'],
            ['titre' => 'Formation gestion de projet', 'type' => 'formation', 'lieu' => 'Centre de formation'],
            ['titre' => 'Audit interne département RH', 'type' => 'mission', 'lieu' => 'Siège social'],
            ['titre' => 'Séminaire de team building', 'type' => 'événement', 'lieu' => 'Hôtel Paradise'],
            ['titre' => 'Revue de performance trimestrielle', 'type' => 'réunion', 'lieu' => 'Bureau direction'],
            ['titre' => 'Formation sécurité au travail', 'type' => 'formation', 'lieu' => 'Salle B'],
            ['titre' => 'Inspection qualité', 'type' => 'mission', 'lieu' => 'Usine'],
            ['titre' => 'Célébration fin d\'année', 'type' => 'événement', 'lieu' => 'Restaurant Le Gourmet'],
            ['titre' => 'Planification stratégique 2026', 'type' => 'réunion', 'lieu' => 'Salle conseil'],
            ['titre' => 'Formation Excel avancé', 'type' => 'formation', 'lieu' => 'Salle informatique'],
            ['titre' => 'Évaluation des risques', 'type' => 'mission', 'lieu' => 'Tous sites'],
            ['titre' => 'Journée portes ouvertes', 'type' => 'événement', 'lieu' => 'Hall d\'accueil'],
            ['titre' => 'Comité de direction', 'type' => 'réunion', 'lieu' => 'Bureau PDG'],
            ['titre' => 'Formation leadership', 'type' => 'formation', 'lieu' => 'Centre de formation'],
            ['titre' => 'Audit financier annuel', 'type' => 'mission', 'lieu' => 'Service comptabilité'],
        ];

        foreach ($activities as $index => $activityData) {
            // Sélectionner un mois et département aléatoires
            $month = $mois[array_rand($mois)];
            $department = $departments->random();
            $responsible = $users->random();
            $statut = $statuts[array_rand($statuts)];
            
            // Créer l'activité
            $activity = Activity::create([
                'titre' => $activityData['titre'],
                'description' => 'Description détaillée de l\'activité ' . $activityData['titre'],
                'type' => $activityData['type'],
                'statut' => $statut,
                'date_prevue' => Carbon::create(2025, $month, rand(1, 28)),
                'heure_debut' => sprintf('%02d:00', rand(8, 17)),
                'heure_fin' => sprintf('%02d:00', rand(10, 18)),
                'lieu' => $activityData['lieu'],
                'department_id' => $department->id,
                'project_id' => $project ? $project->id : null,
                'filiale_id' => $filiale ? $filiale->id : null,
                'agence_id' => $agence ? $agence->id : null,
                'created_by' => $users->first()->id,
                'responsible_id' => $responsible->id,
            ]);

            // Attacher des participants aléatoires (2 à 5 participants)
            $participantsCount = rand(2, min(5, $users->count()));
            $participants = $users->random($participantsCount);
            $activity->participants()->attach($participants->pluck('id'));

            $this->command->info("✓ Activité créée: {$activityData['titre']} (Mois: $month, Responsable: {$responsible->name}, {$participantsCount} participants)");
        }

        $this->command->info('✅ 15 activités de test créées avec succès !');
        $this->command->info('👉 Visitez: http://127.0.0.1:8000/activities/planning');
    }
}
