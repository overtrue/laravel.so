<?php

namespace App\Providers;

use Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        /*
            * 扩展blade
         */
        Blade::extend(function ($view, $compiler) {
            $replace = config('view.extends');

            return preg_replace(array_keys($replace), $replace, $view);
        });
    }

    /**
     * Register any application services.
     */
    public function register()
    {
        //
    }
}
