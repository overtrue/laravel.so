<?php

namespace App\Providers;

use App\Trick;
use App\Observers\TrickObserver;
use Illuminate\Support\ServiceProvider;

class ObserverServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        Trick::observe(TrickObserver::class);
    }

    /**
     * Register any application services.
     */
    public function register()
    {
        //
    }
}
