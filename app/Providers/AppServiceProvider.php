<?php

namespace App\Providers;
use App\Models\User;
use App\Models\Truck;
use App\Observers\UserObserver;
use App\Observers\TruckObserver;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        User::observe(UserObserver::class);
        Truck::observe(TruckObserver::class);
    }
}
