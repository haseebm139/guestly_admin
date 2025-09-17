<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;      // <-- YEH LINE ADD KAREIN
use Illuminate\Support\Facades\Session;

class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        // Pata chalega ke middleware chala ya nahi
        Log::info('--- SetLocale Middleware RUNNING ---');

        if (Session::has('locale')) {
            $locale = Session::get('locale');
            Log::info('Session locale found: ' . $locale);

            App::setLocale($locale);

            // Check karein ke language set hui ya nahi
            Log::info('App locale has been SET to: ' . App::getLocale());
        } else {
            Log::info('Session locale NOT found.');
        }

        return $next($request);
    }
}
