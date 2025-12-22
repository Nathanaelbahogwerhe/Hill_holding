<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Department;
use App\Models\Filiale;
use App\Models\Agence;
use App\Models\User;
use App\Models\Client;
use App\Models\Project;
use App\Models\Task;
use App\Models\Note;

class HomeController extends Controller
{
    /**
     * Page Dashboard
     */
    public function index()
    {
        return view('dashboard');
    }

    /**
     * Renvoie les statistiques du dashboard (AJAX)
     */
    public function data()
    {
        $user = auth()->user();
        $filialeId = $user->filiale_id;
        $isSuperAdmin = $user->hasRole('Super Admin');

        // Si l'utilisateur appartient à une filiale, filtrer les données
        $employeesQuery = Employee::query();
        $departmentsQuery = Department::query();
        $usersQuery = User::query();
        
        if (!$isSuperAdmin && $filialeId) {
            $employeesQuery->where('filiale_id', $filialeId);
            $departmentsQuery->where('filiale_id', $filialeId);
            $usersQuery->where('filiale_id', $filialeId);
        }

        // Exemple de données dynamiques pour le dashboard
        return response()->json([
            'employees' => $employeesQuery->count(),
            'departments' => $departmentsQuery->count(),
            'filiales' => $isSuperAdmin ? Filiale::count() : 1, // Utilisateur de filiale voit 1
            'agences' => $isSuperAdmin ? Agence::count() : Agence::where('filiale_id', $filialeId)->count(),
            'users' => $usersQuery->count(),
            'clients' => Client::count(),
            'projects' => Project::count(),
            'tasks' => Task::count(),
            'notes' => class_exists(Note::class) ? Note::count() : 0,

            // Progression des congés (exemple)
            'leaves' => [
                ['title' => 'Congés pris', 'value' => 40],
                ['title' => 'Congés restants', 'value' => 60],
            ],

            // Progression des projets (exemple)
            'projects_progress' => [
                ['title' => 'Projet Alpha', 'value' => 70],
                ['title' => 'Projet Beta', 'value' => 40],
            ],

            // Dernières actions
            'latest_actions' => [
                'Nouvel employé ajouté : John Doe',
                'Projet Alpha mis à jour',
                'Tâche "Documentation" complétée',
            ],
        ]);
    }
}




