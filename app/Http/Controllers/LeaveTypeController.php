<?php

namespace App\Http\Controllers;

use App\Models\LeaveType;
use Illuminate\Http\Request;

class LeaveTypeController extends Controller
{
    /**
     * Affiche la liste des types de congÃ©s.
     */
    public function index()
    {
        $leaveTypes = LeaveType::latest()->paginate(10);
        return view('leave_types.index', compact('leaveTypes'));
    }

    /**
     * Affiche le formulaire de crÃ©ation dâ€™un type de congÃ©.
     */
    public function create()
    {
        return view('leave_types.create');
    }

    /**
     * Enregistre un nouveau type de congÃ©.
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
            ->with('success', 'Type de congÃ© crÃ©Ã© avec succÃ¨s.');
    }

    /**
     * Affiche les dÃ©tails dâ€™un type de congÃ©.
     */
    public function show(LeaveType $leaveType)
    {
        return view('leave_types.show', compact('leaveType'));
    }

    /**
     * Affiche le formulaire dâ€™Ã©dition dâ€™un type de congÃ©.
     */
    public function edit(LeaveType $leaveType)
    {
        return view('leave_types.edit', compact('leaveType'));
    }

    /**
     * Met Ã  jour un type de congÃ©.
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
            ->with('success', 'Type de congÃ© mis Ã  jour avec succÃ¨s.');
    }

    /**
     * Supprime un type de congÃ©.
     */
    public function destroy(LeaveType $leaveType)
    {
        $leaveType->delete();

        return redirect()->route('leave_types.index')
            ->with('success', 'Type de congÃ© supprimÃ© avec succÃ¨s.');
    }
}







