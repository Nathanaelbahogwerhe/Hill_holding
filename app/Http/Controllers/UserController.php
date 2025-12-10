<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Filiale;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('roles', 'permissions', 'filiale')->paginate(10);
        return view('users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::all();
        $permissions = Permission::all();
        $filiales = Filiale::orderBy('name')->get(); // âœ… AjoutÃ©
        return view('users.create', compact('roles', 'permissions', 'filiales'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'email'       => 'required|email|unique:users,email',
            'password'    => 'required|min:6|confirmed',
            'roles'       => 'array',
            'permissions' => 'array',
            'filiale_id'  => 'nullable|exists:filiales,id', // âœ… validation filiale
        ]);

        $user = User::create([
            'name'       => $request->name,
            'email'      => $request->email,
            'password'   => bcrypt($request->password),
            'filiale_id' => $request->filiale_id,
        ]);

        if ($request->has('roles')) {
            $user->syncRoles($request->roles);
        }

        if ($request->has('permissions')) {
            $user->syncPermissions($request->permissions);
        }

        return redirect()->route('users.index')
            ->with('success', 'Utilisateur crÃ©Ã© avec succÃ¨s âœ…');
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        $permissions = Permission::all();
        $filiales = Filiale::orderBy('name')->get(); // âœ… AjoutÃ©
        $userRoles = $user->roles->pluck('id')->toArray();
        $userPermissions = $user->permissions->pluck('id')->toArray();

        return view('users.edit', compact(
            'user', 'roles', 'permissions', 'userRoles', 'userPermissions', 'filiales'
        ));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'email'       => 'required|email|unique:users,email,' . $user->id,
            'roles'       => 'array',
            'permissions' => 'array',
            'filiale_id'  => 'nullable|exists:filiales,id', // âœ… validation filiale
        ]);

        $user->update([
            'name'       => $request->name,
            'email'      => $request->email,
            'filiale_id' => $request->filiale_id,
        ]);

        if ($request->filled('password')) {
            $user->update(['password' => bcrypt($request->password)]);
        }

        $user->syncRoles($request->roles ?? []);
        $user->syncPermissions($request->permissions ?? []);

        return redirect()->route('users.index')
            ->with('success', 'Utilisateur mis Ã  jour avec succÃ¨s âœ…');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')
            ->with('success', 'Utilisateur supprimÃ© avec succÃ¨s ðŸ—‘ï¸');
    }

    public function show(User $user)
    {
        $filiales = Filiale::orderBy('name')->get(); // si besoin dans show
        return view('users.show', compact('user', 'filiales'));
    }
}







