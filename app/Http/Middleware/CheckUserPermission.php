<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckUserPermission
{
    public function handle($request, Closure $next)
    {
        // Check if the user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Check if the user has permissions
        $userPermission = optional(Auth::user()->getUserPermission);
        if (!$userPermission) {
            return redirect()->route('login');
        }

        return $next($request);
    }
}
