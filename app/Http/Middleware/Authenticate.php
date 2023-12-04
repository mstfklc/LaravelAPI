<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function userCheck(Request $request): ?string
    {
        $user = $request->user();

        if (!$user || !$user->is_admin) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return null;
    }

}
