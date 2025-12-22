<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SystemNotification;
use Illuminate\Http\Request;

class SystemNotificationController extends Controller
{
    public function index()
    {
        $notifications = SystemNotification::with('creator')->latest()->paginate(15);

        return view('admin.system-notifications.index', compact('notifications'));
    }

    public function create()
    {
        return view('admin.system-notifications.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'type' => 'required|in:info,success,warning,error',
            'target' => 'required|in:all,admins,specific_role',
            'role_name' => 'required_if:target,specific_role',
            'expires_at' => 'nullable|date|after:now',
        ]);

        $validated['created_by'] = auth()->id();
        $validated['is_active'] = true;

        SystemNotification::create($validated);

        return redirect()->route('admin.system-notifications.index')->with('success', 'Notification créée');
    }

    public function edit(SystemNotification $systemNotification)
    {
        return view('admin.system-notifications.edit', compact('systemNotification'));
    }

    public function update(Request $request, SystemNotification $systemNotification)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'type' => 'required|in:info,success,warning,error',
            'target' => 'required|in:all,admins,specific_role',
            'role_name' => 'required_if:target,specific_role',
            'is_active' => 'boolean',
            'expires_at' => 'nullable|date|after:now',
        ]);

        $systemNotification->update($validated);

        return redirect()->route('admin.system-notifications.index')->with('success', 'Notification mise à jour');
    }

    public function destroy(SystemNotification $systemNotification)
    {
        $systemNotification->delete();
        return redirect()->route('admin.system-notifications.index')->with('success', 'Notification supprimée');
    }

    public function toggle(SystemNotification $systemNotification)
    {
        $systemNotification->update(['is_active' => !$systemNotification->is_active]);
        
        $status = $systemNotification->is_active ? 'activée' : 'désactivée';
        return redirect()->back()->with('success', "Notification $status");
    }
}
