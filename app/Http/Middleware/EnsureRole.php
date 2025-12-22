<?php

// app/Http/Middleware/EnsureRole.php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = $request->user();
        if (! $user) return redirect()->route('login');

        if (empty($roles)) return $next($request);

        foreach ($roles as $role) {
            if ($user->role === $role || $user->isSuperAdmin()) {
                return $next($request);
            }
        }

        abort(403);
    }
}




