<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistiques générales
        $stats = [
            'users' => [
                'total' => User::count(),
                'active' => User::where('created_at', '>=', now()->subDays(7))->count(),
            ],
            'logs' => [
                'total' => ActivityLog::count(),
                'today' => ActivityLog::whereDate('created_at', today())->count(),
                'week' => ActivityLog::where('created_at', '>=', now()->subWeek())->count(),
            ],
        ];

        // Activités récentes
        $recentActivities = ActivityLog::with('user')
                                      ->latest()
                                      ->take(10)
                                      ->get();

        // Utilisateurs récents
        $recentUsers = User::latest()->take(5)->get();

        // Informations système
        $systemInfo = [
            'php_version' => PHP_VERSION,
            'laravel_version' => app()->version(),
            'environment' => app()->environment(),
            'cache_driver' => config('cache.default'),
            'queue_driver' => config('queue.default'),
            'session_driver' => config('session.driver'),
        ];

        return view('admin.dashboard', compact('stats', 'recentActivities', 'recentUsers', 'systemInfo'));
    }

    public function clearCache()
    {
        try {
            Artisan::call('cache:clear');
            Artisan::call('config:clear');
            Artisan::call('route:clear');
            Artisan::call('view:clear');

            ActivityLog::log('cache_cleared', 'System cache cleared');

            return redirect()->back()->with('success', 'Cache vidé avec succès');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur: ' . $e->getMessage());
        }
    }

    public function optimize()
    {
        try {
            Artisan::call('optimize');
            Artisan::call('config:cache');
            Artisan::call('route:cache');
            Artisan::call('view:cache');

            ActivityLog::log('system_optimized', 'System optimized');

            return redirect()->back()->with('success', 'Système optimisé');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur: ' . $e->getMessage());
        }
    }

    public function systemInfo()
    {
        $info = [
            'server' => [
                'OS' => PHP_OS,
                'Server Software' => $_SERVER['SERVER_SOFTWARE'] ?? 'N/A',
                'PHP Version' => PHP_VERSION,
                'Laravel Version' => app()->version(),
                'Environment' => app()->environment(),
            ],
            'database' => [
                'Driver' => config('database.default'),
                'Host' => config('database.connections.mysql.host'),
                'Database' => config('database.connections.mysql.database'),
            ],
            'cache' => [
                'Driver' => config('cache.default'),
                'Cache Status' => Cache::has('test') ? 'Working' : 'Not Working',
            ],
            'storage' => [
                'Disk Space Total' => disk_total_space('/'),
                'Disk Space Free' => disk_free_space('/'),
            ],
        ];

        return view('admin.system-info', compact('info'));
    }
}
