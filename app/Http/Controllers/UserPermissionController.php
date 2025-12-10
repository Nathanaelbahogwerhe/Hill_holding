<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class UserPermissionController extends Controller
{
    public function edit(User $user)
    {
        $permissions = Permission::all();
        return view('users.permissions', compact('user', 'permissions'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,name',
        ]);

        $user->syncPermissions($request->permissions);

        return redirect()->route('users.index')->with('success', 'Permissions mises Ã  jour âœ…');
    }
}







