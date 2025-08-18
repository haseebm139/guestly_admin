<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyWebSocketAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
         // Skip verification for local testing
        if ($request->header('origin') === 'https://guestly.space' ||
            $request->header('host') === '127.0.0.1:6001') {
            return $next($request);
        }

        return response('Forbidden', 403);
    }
}
