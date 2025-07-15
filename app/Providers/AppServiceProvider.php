<?php

namespace App\Providers;

use App\Core\KTBootstrap;
use Illuminate\Database\Schema\Builder;
use Illuminate\Support\ServiceProvider;
use App\Interfaces\PlanRepositoryInterface;
use App\Interfaces\FeatureRepositoryInterface;
use App\Repositories\PlanRepository;
use App\Repositories\FeatureRepository;
use App\Repositories\Admin\SupplyRepositoryInterface;
use App\Repositories\Admin\SupplyRepository;

// Repositories API
use App\Repositories\API\UserRepositoryInterface;
use App\Repositories\API\UserRepository;

use App\Repositories\API\SubscriptionRepository;
use App\Repositories\API\SubscriptionRepositoryInterface;

use App\Services\Subscription\SubscriptionServiceInterface;
use App\Services\Subscription\SubscriptionService;
use App\Repositories\API\CardRepositoryInterface;
use App\Repositories\API\CardRepository;
use App\Repositories\API\SpotBookingRepositoryInterface;
use App\Repositories\API\SpotBookingRepository;

// STUDIO
use App\Repositories\API\Studio\StudioRepository;
use App\Repositories\API\Studio\StudioRepositoryInterface;
use App\Repositories\API\Studio\BoostAdRepository;
use App\Repositories\API\Studio\BoostAdRepositoryInterface;


// ARTIST
use App\Repositories\API\Artist\ArtistRepository;
use App\Repositories\API\Artist\ArtistRepositoryInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

        // ADMIN
        $this->app->bind(PlanRepositoryInterface::class, PlanRepository::class);
        $this->app->bind(FeatureRepositoryInterface::class, FeatureRepository::class);
        $this->app->bind(SupplyRepositoryInterface::class, SupplyRepository::class );
        $this->app->bind(
         UserRepositoryInterface::class,
         UserRepository::class
        );
        $this->app->bind(CardRepositoryInterface::class,CardRepository::class);
        $this->app->bind(SubscriptionRepositoryInterface::class, SubscriptionRepository::class);
        $this->app->bind(SpotBookingRepositoryInterface::class, SpotBookingRepository::class);

        // STUDIO
        $this->app->bind(StudioRepositoryInterface::class, StudioRepository::class);
        $this->app->bind(BoostAdRepositoryInterface::class,BoostAdRepository::class);


        // ARTIST

        $this->app->bind(ArtistRepositoryInterface::class, ArtistRepository::class);
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
