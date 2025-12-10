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
        // Exemple de donnÃ©es dynamiques pour le dashboard
        return response()->json([
            'employees' => Employee::count(),
            'departments' => Department::count(),
            'filiales' => Filiale::count(),
            'agences' => Agence::count(),
            'users' => User::count(),
            'clients' => Client::count(),
            'projects' => Project::count(),
            'tasks' => Task::count(),
            'notes' => class_exists(Note::class) ? Note::count() : 0,

            // Progression des congÃ©s (exemple)
            'leaves' => [
                ['title' => 'CongÃ©s pris', 'value' => 40],
                ['title' => 'CongÃ©s restants', 'value' => 60],
            ],

            // Progression des projets (exemple)
            'projects_progress' => [
                ['title' => 'Projet Alpha', 'value' => 70],
                ['title' => 'Projet Beta', 'value' => 40],
            ],

            // DerniÃ¨res actions
            'latest_actions' => [
                'Nouvel employÃ© ajoutÃ© : John Doe',
                'Projet Alpha mis Ã  jour',
                'TÃ¢che "Documentation" complÃ©tÃ©e',
            ],
        ]);
    }
}







