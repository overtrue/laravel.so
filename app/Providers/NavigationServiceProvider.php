<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Navigation\Builder;

class NavigationServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->app['navigation.builder'] = $this->app->share(function ($app) {
            return new Builder($app['config'], $app['auth']);
        });
    }
}
