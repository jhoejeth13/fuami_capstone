<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Helpers\LocationHelper;

class LocationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(LocationHelper::class, function ($app) {
            return new LocationHelper();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
