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
     * Afficher la liste des dÃ©partements
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Department::query();

        // ðŸ” Recherche
        if ($request->filled('search')) {
            $search = trim($request->input('search'));
            $query->where('name', 'like', "%{$search}%");
        }

        // ðŸŽšï¸ Filtrage selon le rÃ´le et la filiale de lâ€™utilisateur
        if ($user->hasRole('Super Admin')) {
            $departments = $query->orderBy('name')->paginate(10);
        } elseif (!empty($user->filiale_id)) {
            $departments = $query->where('filiale_id', $user->filiale_id)
                                 ->orderBy('name')
                                 ->paginate(10);
        } else {
            // Aucun accÃ¨s
            $departments = collect(); // tableau vide
        }

        return view('departments.index', compact('departments'));
    }

    /**
     * Formulaire de crÃ©ation
     */
    public function create()
    {
        $user = Auth::user();

        $filiales = $user->hasRole('Super Admin')
            ? Filiale::orderBy('name')->get()
            : Filiale::where('id', $user->filiale_id)->get();

        return view('departments.create', compact('filiales'));
    }

    /**
     * Enregistrer un nouveau dÃ©partement
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name'       => 'required|string|max:255',
            'filiale_id' => 'nullable|exists:filiales,id',
        ]);

        $filialeId = $request->filiale_id ?? $user->filiale_id;

        $department = Department::create([
            'name'       => $request->name,
            'filiale_id' => $filialeId,
        ]);

        // ðŸ”” Notification aux administrateurs
        Notify::admins(
            'Nouveau dÃ©partement crÃ©Ã©',
            'Le dÃ©partement "' . e($department->name) . '" a Ã©tÃ© ajoutÃ©.',
            route('departments.index')
        );

        return redirect()
            ->route('departments.index')
            ->with('success', 'DÃ©partement crÃ©Ã© avec succÃ¨s.');
    }

    /**
     * Afficher les dÃ©tails dâ€™un dÃ©partement
     */
    public function show(Department $department)
    {
        // Charger la relation employees (si elle existe)
        $department->load(['filiale', 'employees']);

        return view('departments.show', compact('department'));
    }

    /**
     * Formulaire dâ€™Ã©dition
     */
    public function edit(Department $department)
    {
        $user = Auth::user();

        $filiales = $user->hasRole('Super Admin')
            ? Filiale::orderBy('name')->get()
            : Filiale::where('id', $user->filiale_id)->get();

        return view('departments.edit', compact('department', 'filiales'));
    }

    /**
     * Mettre Ã  jour un dÃ©partement
     */
    public function update(Request $request, Department $department)
    {
        $user = Auth::user();

        $request->validate([
            'name'       => 'required|string|max:255',
            'filiale_id' => 'nullable|exists:filiales,id',
        ]);

        $filialeId = $request->filiale_id ?? $user->filiale_id;

        $department->update([
            'name'       => $request->name,
            'filiale_id' => $filialeId,
        ]);

        return redirect()
            ->route('departments.index')
            ->with('success', 'DÃ©partement mis Ã  jour avec succÃ¨s.');
    }

    /**
     * Supprimer un dÃ©partement
     */
    public function destroy(Department $department)
    {
        $department->delete();

        return redirect()
            ->route('departments.index')
            ->with('success', 'DÃ©partement supprimÃ© avec succÃ¨s.');
    }
}







