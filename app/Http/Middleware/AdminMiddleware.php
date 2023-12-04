<?php

namespace App\Http\Middleware;

use Closure;

class AdminMiddleware
{
    public function handle($request, Closure $next)
    {
        if (!auth()->check() || !auth()->user()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        $user = auth()->user();
        if (!property_exists($user, 'is_admin')) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        if (!$user->is_admin) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return $next($request);
    }
}
