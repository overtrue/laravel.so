<?php

namespace App\Providers;

use Hashids\Hashids;
use Illuminate\Support\ServiceProvider;

class HashidsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('hashids', function(){
            return new Hashids('laravel.so', 8, 'abcdefghij1234567890');
        });
    }
}
