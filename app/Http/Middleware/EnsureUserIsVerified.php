<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureUserIsVerified
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return $next($request);
        }

        if ($request->routeIs('logout')) {
            return $next($request);
        }

        if ($request->routeIs('logout') || $request->routeIs('stripe.*')) {
            return $next($request);
        }
        if ($request->routeIs('verify.documents') || $request->routeIs('generate.otp') || $request->routeIs('auth.verify.otp') || $request->routeIs('auth.resend.otp')|| $request->routeIs('auth.verify.phone')) {
            return $next($request);
        }
        $user = Auth::user();
        $status = $user->verification_status;
        $role = $user->user_type;

        $dashboardRoute = ($role === 'artist') ? 'dashboard.explore' : 'dashboard.studio_home';

        if ($request->routeIs('choose_plan')) {
            if ($status == '1') {
                $verificationRoute = ($role === 'artist') ? 'user_identification' : 'studio_step_form';
                return redirect()->route($verificationRoute);
            }
            if ($status == '2') {
                return redirect()->route($dashboardRoute);
            }
        }

        if ($request->routeIs('user_identification') || $request->routeIs('studio_step_form')) {
            if ($status == '0') {
                return redirect()->route('choose_plan');
            }
            if ($status == '2') {
                return redirect()->route($dashboardRoute);
            }
        }

             if (!$request->routeIs('choose_plan') && !$request->routeIs('user_identification') && !$request->routeIs('studio_step_form')) {
            if ($status == '0') {
                return redirect()->route('choose_plan');
            }
            if ($status == '1') {
                $verificationRoute = ($role === 'artist') ? 'user_identification' : 'studio_step_form';
                return redirect()->route($verificationRoute);
            }
        }
             return $next($request);
    }
}
