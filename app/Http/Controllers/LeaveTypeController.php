<?php

namespace App\Http\Controllers;

use App\Models\LeaveType;
use Illuminate\Http\Request;

class LeaveTypeController extends Controller
{
    /**
     * Affiche la liste des types de congés.
     */
    public function index()
    {
        $leaveTypes = LeaveType::latest()->paginate(10);
        return view('leave_types.index', compact('leaveTypes'));
    }

    /**
     * Affiche le formulaire de création d’un type de congé.
     */
    public function create()
    {
        return view('leave_types.create');
    }

    /**
     * Enregistre un nouveau type de congé.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255|unique:leave_types,name',
            'description' => 'nullable|string|max:1000',
            'days'        => 'required|integer|min:1',
        ]);

        LeaveType::create($validated);

        return redirect()->route('leave_types.index')
            ->with('success', 'Type de congé créé avec succès.');
    }

    /**
     * Affiche les détails d’un type de congé.
     */
    public function show(LeaveType $leaveType)
    {
        return view('leave_types.show', compact('leaveType'));
    }

    /**
     * Affiche le formulaire d’édition d’un type de congé.
     */
    public function edit(LeaveType $leaveType)
    {
        return view('leave_types.edit', compact('leaveType'));
    }

    /**
     * Met à jour un type de congé.
     */
    public function update(Request $request, LeaveType $leaveType)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255|unique:leave_types,name,' . $leaveType->id,
            'description' => 'nullable|string|max:1000',
            'days'        => 'required|integer|min:1',
        ]);

        $leaveType->update($validated);

        return redirect()->route('leave_types.index')
            ->with('success', 'Type de congé mis à jour avec succès.');
    }

    /**
     * Supprime un type de congé.
     */
    public function destroy(LeaveType $leaveType)
    {
        $leaveType->delete();

        return redirect()->route('leave_types.index')
            ->with('success', 'Type de congé supprimé avec succès.');
    }
}




