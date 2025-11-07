<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;

class RestrictAdminRoutes
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        // Agar login nahi hai to normal flow
        if (!$user) {
            return $next($request);
        }

        // Agar artist hai aur admin route hit kare
        if ($user->user_type === 'artist' && $request->is('admin') || $request->is('admin/*')) {
            return redirect(RouteServiceProvider::ARTIST_HOME);
        }

        // Agar studio hai aur admin route hit kare
        if ($user->user_type === 'studio' && $request->is('admin') || $request->is('admin/*')) {
            return redirect(RouteServiceProvider::STUDIO_HOME);
        }

        return $next($request);
    }
}
