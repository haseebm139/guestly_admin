<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/dashboard';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));
            // Admin API
            Route::prefix('api/v1/admin')
                ->middleware(['api', 'auth:api', 'admin'])
                ->name('api.admin.')
                ->group(base_path('routes/api/admin.php'));

            // Studio API
            Route::prefix('api/v1/studio')
                ->middleware(['api', 'auth:api', 'studio'])
                ->name('api.studio.')
                ->group(base_path('routes/api/studio.php'));

            // Artist API
            Route::prefix('api/v1/artist')
                ->middleware(['api', 'auth:api', 'artist'])
                ->name('api.artist.')
                ->group(base_path('routes/api/artist.php'));
            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }
}
