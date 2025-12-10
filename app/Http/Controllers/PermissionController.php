<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function __construct()
    {
        // Seul le Super Admin peut gÃ©rer les permissions
        $this->middleware('role:Super Admin');
    }

    /**
     * Affiche la liste des permissions
     */
    public function index()
    {
        $permissions = Permission::all();
        return view('permissions.index', compact('permissions'));
    }

    /**
     * Formulaire de crÃ©ation
     */
    public function create()
    {
        return view('permissions.create');
    }

    /**
     * Enregistrer une nouvelle permission
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:permissions,name',
        ]);

        Permission::create([
            'name' => $request->name,
            'guard_name' => 'web',
        ]);

        return redirect()->route('permissions.index')->with('success', 'Permission crÃ©Ã©e avec succÃ¨s.');
    }

    /**
     * Formulaire dâ€™Ã©dition
     */
    public function edit(Permission $permission)
    {
        return view('permissions.edit', compact('permission'));
    }

    /**
     * Mettre Ã  jour une permission
     */
    public function update(Request $request, Permission $permission)
    {
        $request->validate([
            'name' => 'required|unique:permissions,name,' . $permission->id,
        ]);

        $permission->update(['name' => $request->name]);

        return redirect()->route('permissions.index')->with('success', 'Permission mise Ã  jour avec succÃ¨s.');
    }

    /**
     * Supprimer une permission
     */
    public function destroy(Permission $permission)
    {
        $permission->delete();
        return redirect()->route('permissions.index')->with('success', 'Permission supprimÃ©e avec succÃ¨s.');
    }
}







