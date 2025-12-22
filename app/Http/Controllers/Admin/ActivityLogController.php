<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $query = ActivityLog::with('user')->latest();

        // Filtres
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }
        
        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }
        
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $logs = $query->paginate(50);
        
        // Actions uniques pour le filtre
        $actions = ActivityLog::distinct()->pluck('action');
        
        // Utilisateurs pour le filtre
        $users = \App\Models\User::orderBy('name')->get(['id', 'name']);
        
        // Statistiques
        $stats = [
            'total' => ActivityLog::count(),
            'today' => ActivityLog::whereDate('created_at', today())->count(),
            'week' => ActivityLog::where('created_at', '>=', now()->subWeek())->count(),
        ];

        return view('admin.activity-logs.index', compact('logs', 'actions', 'users', 'stats'));
    }

    public function show(ActivityLog $activityLog)
    {
        $activityLog->load('user');
        return view('admin.activity-logs.show', compact('activityLog'));
    }

    public function destroy(ActivityLog $activityLog)
    {
        $activityLog->delete();
        return redirect()->route('admin.activity-logs.index')->with('success', 'Log supprimé');
    }

    public function clear(Request $request)
    {
        $days = $request->input('days', 30);
        
        $deleted = ActivityLog::where('created_at', '<', now()->subDays($days))->delete();
        
        ActivityLog::log('system_maintenance', "Cleared $deleted activity logs older than $days days");
        
        return redirect()->route('admin.activity-logs.index')->with('success', "$deleted logs supprimés");
    }
}
