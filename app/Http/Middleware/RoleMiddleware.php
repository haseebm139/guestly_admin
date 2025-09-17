<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle($request, Closure $next, $role = null)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        if (auth()->user()->role_id !== $role) {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }

}

