<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Stock;
use App\Models\Report;
use App\Models\ReportSchedule;
use App\Models\Activity;
use App\Models\DailyOperation;
use App\Models\Evaluation;
use App\Models\User;
use App\Models\Department;
use App\Models\Project;
use App\Models\Task;
use App\Models\Filiale;
use App\Models\Agence;

class OperationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Récupération des entités nécessaires
        $filiale = Filiale::first();
        $agence = Agence::first();
        $department = Department::first();
        $project = Project::first();
        $task = Task::first();
        $user = User::where('email', 'admin@hillholding.com')->first() 
                ?? User::first();

        // 1. STOCK - Données de test
        if ($filiale) {
            $articles = [
                ['Ordinateurs portables', 15, 850.00],
                ['Téléphones portables', 30, 350.00],
                ['Imprimantes', 8, 450.00],
                ['Papier A4 (ramettes)', 200, 5.50],
                ['Stylos (boîtes de 50)', 100, 12.00],
            ];

            foreach ($articles as $index => [$article, $quantite, $prix_unitaire]) {
                // Entrée de stock
                Stock::create([
                    'date' => now()->subDays(30 - $index),
                    'articles' => $article,
                    'quantite' => $quantite,
                    'prix_unitaire' => $prix_unitaire,
                    'prix_total' => $quantite * $prix_unitaire,
                    'entree' => $quantite,
                    'sortie' => 0,
                    'destination' => null,
                    'solde' => $quantite,
                    'fournisseur' => 'Fournisseur ' . chr(65 + $index),
                    'filiale_id' => $filiale->id,
                    'agence_id' => null,
                ]);

                // Sortie de stock
                $sortie = round($quantite * 0.3);
                Stock::create([
                    'date' => now()->subDays(15 - $index),
                    'articles' => $article,
                    'quantite' => $sortie,
                    'prix_unitaire' => $prix_unitaire,
                    'prix_total' => $sortie * $prix_unitaire,
                    'entree' => 0,
                    'sortie' => $sortie,
                    'destination' => $agence ? $agence->nom : 'Agence Centrale',
                    'solde' => $quantite - $sortie,
                    'fournisseur' => null,
                    'filiale_id' => $filiale->id,
                    'agence_id' => null,
                ]);
            }
        }

        // 2. REPORTS - Données de test
        if ($user && $department) {
            $reports = [
                [
                    'titre' => 'Rapport Hebdomadaire - Semaine 51',
                    'type' => 'hebdomadaire',
                    'contenu' => "## Activités de la semaine\n\n- Mise en place du nouveau système de gestion\n- Formation du personnel\n- Audit des procédures\n\n## Indicateurs clés\n\n- 15 nouveaux clients\n- 98% de satisfaction\n- Chiffre d'affaires: 125,000 €",
                    'statut' => 'validé',
                    'date_debut' => now()->subDays(14),
                    'date_fin' => now()->subDays(7),
                ],
                [
                    'titre' => 'Rapport Mensuel - Décembre 2025',
                    'type' => 'mensuel',
                    'contenu' => "## Bilan du mois\n\n### Réalisations\n- Objectifs atteints à 110%\n- 3 nouveaux projets lancés\n\n### Difficultés\n- Retard sur livraison matériel\n\n### Prévisions janvier\n- Recrutement de 5 nouveaux collaborateurs",
                    'statut' => 'soumis',
                    'date_debut' => now()->subDays(30),
                    'date_fin' => now(),
                ],
                [
                    'titre' => 'Rapport de Projet - Infrastructure IT',
                    'type' => 'projet',
                    'contenu' => "## État d'avancement\n\n- Phase 1: Complétée (100%)\n- Phase 2: En cours (65%)\n- Phase 3: Planifiée\n\n## Budget\n- Consommé: 75,000 €\n- Restant: 25,000 €",
                    'statut' => 'brouillon',
                    'date_debut' => now()->subDays(60),
                    'date_fin' => now(),
                ],
            ];

            foreach ($reports as $reportData) {
                $report = Report::create([
                    'titre' => $reportData['titre'],
                    'type' => $reportData['type'],
                    'contenu' => $reportData['contenu'],
                    'statut' => $reportData['statut'],
                    'date_debut' => $reportData['date_debut'],
                    'date_fin' => $reportData['date_fin'],
                    'soumis_par' => $user->id,
                    'date_soumission' => in_array($reportData['statut'], ['soumis', 'validé']) ? now()->subDays(5) : null,
                    'valide_par' => $reportData['statut'] === 'validé' ? $user->id : null,
                    'date_validation' => $reportData['statut'] === 'validé' ? now()->subDays(2) : null,
                    'department_id' => $department->id,
                    'project_id' => $reportData['type'] === 'projet' && $project ? $project->id : null,
                    'filiale_id' => $filiale ? $filiale->id : null,
                    'agence_id' => null,
                ]);
            }
        }

        // 3. REPORT SCHEDULES - Calendrier de rapports
        if ($department && $user) {
            $schedules = [
                [
                    'nom' => 'Rapport Opérationnel Quotidien',
                    'type_rapport' => 'journalier',
                    'frequence' => 'daily',
                    'heure_echeance' => '17:00',
                ],
                [
                    'nom' => 'Rapport Hebdomadaire Département',
                    'type_rapport' => 'hebdomadaire',
                    'frequence' => 'weekly',
                    'jour_semaine' => 5, // Vendredi
                    'heure_echeance' => '16:00',
                ],
                [
                    'nom' => 'Bilan Mensuel des Activités',
                    'type_rapport' => 'mensuel',
                    'frequence' => 'monthly',
                    'jour_mois' => 1, // 1er du mois
                    'heure_echeance' => '10:00',
                ],
            ];

            foreach ($schedules as $scheduleData) {
                $schedule = ReportSchedule::create([
                    'nom' => $scheduleData['nom'],
                    'type_rapport' => $scheduleData['type_rapport'],
                    'frequence' => $scheduleData['frequence'],
                    'jour_semaine' => $scheduleData['jour_semaine'] ?? null,
                    'jour_mois' => $scheduleData['jour_mois'] ?? null,
                    'heure_echeance' => $scheduleData['heure_echeance'],
                    'department_id' => $department->id,
                    'responsable_id' => $user->id,
                    'filiale_id' => $filiale ? $filiale->id : null,
                    'agence_id' => null,
                    'active' => true,
                    'derniere_soumission' => now()->subDays(rand(1, 7)),
                ]);
                
                $schedule->calculateNextDeadline();
                $schedule->save();
            }
        }

        // 4. ACTIVITIES - Activités planifiées
        if ($user && $department) {
            $activities = [
                [
                    'titre' => 'Réunion Stratégique Mensuelle',
                    'type' => 'réunion',
                    'description' => 'Revue des objectifs et planification du mois à venir',
                    'date_prevue' => now()->addDays(3),
                    'heure_debut' => '09:00',
                    'heure_fin' => '11:00',
                    'lieu' => 'Salle de Conférence A',
                    'statut' => 'planifiée',
                ],
                [
                    'titre' => 'Formation Nouvelle Procédure',
                    'type' => 'formation',
                    'description' => 'Formation du personnel sur les nouvelles procédures de sécurité',
                    'date_prevue' => now()->addDays(7),
                    'heure_debut' => '14:00',
                    'heure_fin' => '17:00',
                    'lieu' => 'Salle de Formation',
                    'statut' => 'planifiée',
                ],
                [
                    'titre' => 'Mission Client - Audit Site',
                    'type' => 'mission',
                    'description' => 'Audit des installations chez le client XYZ',
                    'date_prevue' => now()->addDays(10),
                    'heure_debut' => '08:00',
                    'heure_fin' => '18:00',
                    'lieu' => 'Site Client XYZ',
                    'statut' => 'planifiée',
                ],
                [
                    'titre' => 'Séminaire Team Building',
                    'type' => 'événement',
                    'description' => 'Activité de cohésion d\'équipe',
                    'date_prevue' => now()->addDays(15),
                    'heure_debut' => '10:00',
                    'heure_fin' => '16:00',
                    'lieu' => 'Centre de Loisirs',
                    'statut' => 'planifiée',
                ],
            ];

            $allUsers = User::limit(3)->pluck('id')->toArray();

            foreach ($activities as $activityData) {
                Activity::create([
                    'titre' => $activityData['titre'],
                    'type' => $activityData['type'],
                    'description' => $activityData['description'],
                    'date_prevue' => $activityData['date_prevue'],
                    'heure_debut' => $activityData['heure_debut'],
                    'heure_fin' => $activityData['heure_fin'],
                    'lieu' => $activityData['lieu'],
                    'statut' => $activityData['statut'],
                    'participants' => json_encode($allUsers),
                    'department_id' => $department->id,
                    'project_id' => $project ? $project->id : null,
                    'filiale_id' => $filiale ? $filiale->id : null,
                    'agence_id' => null,
                    'created_by' => $user->id,
                ]);
            }
        }

        // 5. DAILY OPERATIONS - Opérations journalières
        if ($user && $project && $department) {
            for ($i = 7; $i >= 1; $i--) {
                DailyOperation::create([
                    'date' => now()->subDays($i),
                    'activites_realisees' => "- Installation des équipements\n- Configuration des systèmes\n- Tests de validation\n- Documentation technique",
                    'problemes_rencontres' => $i % 3 === 0 ? "- Retard livraison matériel\n- Problème technique sur serveur" : null,
                    'solutions_apportees' => $i % 3 === 0 ? "- Contact fournisseur pour accélérer livraison\n- Redémarrage et patch appliqué" : null,
                    'previsions_lendemain' => "- Finaliser l'installation\n- Former les utilisateurs\n- Préparer rapport de clôture",
                    'nombre_personnel' => rand(5, 12),
                    'observations' => $i === 1 ? 'Excellente progression, équipe motivée' : null,
                    'project_id' => $project->id,
                    'department_id' => $department->id,
                    'filiale_id' => $filiale ? $filiale->id : null,
                    'agence_id' => null,
                    'soumis_par' => $user->id,
                ]);
            }
        }

        // 6. EVALUATIONS - Évaluations
        if ($user && $project && $task) {
            $evaluations = [
                [
                    'type' => 'projet',
                    'evaluable_type' => 'App\Models\Project',
                    'evaluable_id' => $project->id,
                    'note' => 85,
                    'commentaires' => 'Excellent projet mené avec professionnalisme et efficacité.',
                    'points_forts' => "- Respect des délais\n- Qualité du livrable\n- Communication fluide\n- Gestion budgétaire rigoureuse",
                    'points_amelioration' => "- Documentation technique à enrichir\n- Tests de charge à anticiper",
                    'recommandations' => "- Reproduire cette méthodologie sur les prochains projets\n- Former d'autres équipes sur ces bonnes pratiques",
                ],
                [
                    'type' => 'tâche',
                    'evaluable_type' => 'App\Models\Task',
                    'evaluable_id' => $task->id,
                    'note' => 72,
                    'commentaires' => 'Tâche bien réalisée avec quelques points à améliorer.',
                    'points_forts' => "- Respect des standards de qualité\n- Proactivité dans la résolution des problèmes",
                    'points_amelioration' => "- Délai légèrement dépassé\n- Communication des difficultés à améliorer",
                    'recommandations' => "- Planifier des points d'étape réguliers\n- Alerter plus tôt en cas de blocage",
                ],
            ];

            foreach ($evaluations as $evalData) {
                Evaluation::create([
                    'type' => $evalData['type'],
                    'evaluable_type' => $evalData['evaluable_type'],
                    'evaluable_id' => $evalData['evaluable_id'],
                    'note' => $evalData['note'],
                    'commentaires' => $evalData['commentaires'],
                    'points_forts' => $evalData['points_forts'],
                    'points_amelioration' => $evalData['points_amelioration'],
                    'recommandations' => $evalData['recommandations'],
                    'evaluateur_id' => $user->id,
                    'evaluated_user_id' => null,
                ]);
            }
        }

        $this->command->info('✅ Données de test du module Operations créées avec succès!');
        $this->command->info('   - Stock: 10 mouvements (entrées/sorties)');
        $this->command->info('   - Reports: 3 rapports (brouillon, soumis, validé)');
        $this->command->info('   - Report Schedules: 3 calendriers (quotidien, hebdo, mensuel)');
        $this->command->info('   - Activities: 4 activités planifiées');
        $this->command->info('   - Daily Operations: 7 rapports journaliers');
        $this->command->info('   - Evaluations: 2 évaluations (projet, tâche)');
    }
}
