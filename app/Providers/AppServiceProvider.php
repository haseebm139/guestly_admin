<?php

namespace App\Providers;

use App\Core\KTBootstrap;
use Illuminate\Database\Schema\Builder;
use Illuminate\Support\ServiceProvider;
use App\Interfaces\PlanRepositoryInterface;
use App\Interfaces\FeatureRepositoryInterface;
use App\Repositories\PlanRepository;
use App\Repositories\FeatureRepository;

// Repositories API
use App\Repositories\API\UserRepositoryInterface;
use App\Repositories\API\UserRepository;

use App\Repositories\API\SubscriptionRepository;
use App\Repositories\API\SubscriptionRepositoryInterface;
use App\Services\Subscription\SubscriptionServiceInterface;
use App\Services\Subscription\SubscriptionService;

use App\Repositories\API\Studio\StudioRepository;
use App\Repositories\API\Studio\StudioRepositoryInterface;

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
        $this->app->bind(
         UserRepositoryInterface::class,
         UserRepository::class
        );
        $this->app->bind(SubscriptionRepositoryInterface::class, SubscriptionRepository::class);

        $this->app->bind(StudioRepositoryInterface::class, StudioRepository::class);
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
