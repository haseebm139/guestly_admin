<?php

namespace App\Providers;

use App\Core\KTBootstrap;
use Illuminate\Database\Schema\Builder;
use Illuminate\Support\ServiceProvider;
use App\Interfaces\PlanRepositoryInterface;
use App\Interfaces\FeatureRepositoryInterface;
use App\Repositories\PlanRepository;
use App\Repositories\FeatureRepository;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(PlanRepositoryInterface::class, PlanRepository::class);
        $this->app->bind(FeatureRepositoryInterface::class, FeatureRepository::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Update defaultStringLength
        Builder::defaultStringLength(191);

        KTBootstrap::init();
    }
}
