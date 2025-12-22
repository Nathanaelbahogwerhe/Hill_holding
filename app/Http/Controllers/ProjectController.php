<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use App\Models\Filiale;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    // Liste des projets
    public function index()
    {
        $user = auth()->user();

        if ($user && $user->isSuperAdmin()) {
            $projects = Project::with('responsible')->latest()->get();
        } else {
            $projects = Project::with('responsible')
                ->whereHas('responsible', function ($q) use ($user) {
                    $q->where('filiale_id', $user->filiale_id)
                      ->orWhereNull('filiale_id');
                })
                ->latest()
                ->get();
        }

        return view('projects.index', compact('projects'));
    }

    // Formulaire de création
    public function create()
    {
        $user = auth()->user();

        if ($user && $user->isSuperAdmin()) {
            $users = User::all();
        } else {
            $users = User::where('filiale_id', $user->filiale_id)
                ->orWhereNull('filiale_id')
                ->get();
        }

        // optionally provide filiales if you need them in the form
        $filiales = Filiale::all();

        return view('projects.create', compact('users', 'filiales'));
    }

    // Enregistrement d’un nouveau projet
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'           => 'required|string|max:255',
            'responsible_id' => 'nullable|exists:users,id',
            'description'    => 'nullable|string',
            'details'        => 'nullable|string',
            'status'         => 'required|in:En cours,Terminé,En attente',
            'start_date'     => 'nullable|date',
            'end_date'       => 'nullable|date|after_or_equal:start_date',
            'due_date'       => 'nullable|date|after_or_equal:start_date',
        ]);

        Project::create($validated);

        return redirect()->route('projects.index')->with('success', 'Projet créé avec succès.');
    }

    // Affichage d’un projet
    public function show(Project $project)
    {
        $project->load('responsible');
        return view('projects.show', compact('project'));
    }

    // Formulaire d’édition
    public function edit(Project $project)
    {
        $user = auth()->user();

        if ($user && $user->isSuperAdmin()) {
            $users = User::all();
        } else {
            $users = User::where('filiale_id', $user->filiale_id)
                ->orWhereNull('filiale_id')
                ->get();
        }

        $filiales = Filiale::all();

        return view('projects.edit', compact('project', 'users', 'filiales'));
    }

    // Mise à jour du projet
    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'name'           => 'required|string|max:255',
            'responsible_id' => 'nullable|exists:users,id',
            'description'    => 'nullable|string',
            'details'        => 'nullable|string',
            'status'         => 'required|in:En cours,Terminé,En attente',
            'start_date'     => 'nullable|date',
            'end_date'       => 'nullable|date|after_or_equal:start_date',
            'due_date'       => 'nullable|date|after_or_equal:start_date',
        ]);

        $project->update($validated);

        return redirect()->route('projects.index')->with('success', 'Projet mis à jour avec succès.');
    }

    // Suppression du projet
    public function destroy(Project $project)
    {
        $project->delete();
        return redirect()->route('projects.index')->with('success', 'Projet supprimé avec succès.');
    }
}




