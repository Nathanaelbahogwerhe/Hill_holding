<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Filiale;
use App\Helpers\Notify;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DepartmentController extends Controller
{
    /**
     * Afficher la liste des départements
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Department::query();

        // 🔍 Recherche
        if ($request->filled('search')) {
            $search = trim($request->input('search'));
            $query->where('name', 'like', "%{$search}%");
        }

        // 🎚️ Filtrage selon le rôle et la filiale de l’utilisateur
        if ($user->hasRole('Super Admin')) {
            $departments = $query->orderBy('name')->paginate(10);
        } elseif (!empty($user->filiale_id)) {
            $departments = $query->where('filiale_id', $user->filiale_id)
                                 ->orderBy('name')
                                 ->paginate(10);
        } else {
            // Aucun accès
            $departments = collect(); // tableau vide
        }

        return view('departments.index', compact('departments'));
    }

    /**
     * Formulaire de création
     */
    public function create()
    {
        $user = Auth::user();

        $filiales = $user->hasRole('Super Admin')
            ? Filiale::orderBy('name')->get()
            : Filiale::where('id', $user->filiale_id)->get();

        $agences = \App\Models\Agence::orderBy('name')->get();

        return view('departments.create', compact('filiales', 'agences'));
    }

    /**
     * Enregistrer un nouveau département
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name'       => 'required|string|max:255',
            'code'       => 'nullable|string|max:50',
            'filiale_id' => 'nullable|exists:filiales,id',
            'agency_id'  => 'nullable|exists:agences,id',
        ]);

        $filialeId = $request->filiale_id ?? $user->filiale_id;

        $department = Department::create([
            'name'       => $request->name,
            'code'       => $request->code,
            'filiale_id' => $filialeId,
            'agency_id'  => $request->agency_id,
        ]);

        // 🔔 Notification aux administrateurs
        Notify::admins(
            'Nouveau département créé',
            'Le département "' . e($department->name) . '" a été ajouté.',
            route('departments.index')
        );

        return redirect()
            ->route('departments.index')
            ->with('success', 'Département créé avec succès.');
    }

    /**
     * Afficher les détails d’un département
     */
    public function show(Department $department)
    {
        // Charger la relation employees (si elle existe)
        $department->load(['filiale', 'employees']);

        return view('departments.show', compact('department'));
    }

    /**
     * Formulaire d’édition
     */
    public function edit(Department $department)
    {
        $user = Auth::user();

        $filiales = $user->hasRole('Super Admin')
            ? Filiale::orderBy('name')->get()
            : Filiale::where('id', $user->filiale_id)->get();

        $agences = \App\Models\Agence::orderBy('name')->get();

        return view('departments.edit', compact('department', 'filiales', 'agences'));
    }

    /**
     * Mettre à jour un département
     */
    public function update(Request $request, Department $department)
    {
        $user = Auth::user();

        $request->validate([
            'name'       => 'required|string|max:255',
            'code'       => 'nullable|string|max:50',
            'filiale_id' => 'nullable|exists:filiales,id',
            'agency_id'  => 'nullable|exists:agences,id',
        ]);

        $filialeId = $request->filiale_id ?? $user->filiale_id;

        $department->update([
            'name'       => $request->name,
            'code'       => $request->code,
            'filiale_id' => $filialeId,
            'agency_id'  => $request->agency_id,
        ]);

        return redirect()
            ->route('departments.index')
            ->with('success', 'Département mis à jour avec succès.');
    }

    /**
     * Supprimer un département
     */
    public function destroy(Department $department)
    {
        $department->delete();

        return redirect()
            ->route('departments.index')
            ->with('success', 'Département supprimé avec succès.');
    }
}




