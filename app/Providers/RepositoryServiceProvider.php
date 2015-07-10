<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->app->bind(
            'App\Repositories\UserRepositoryInterface',
            'App\Repositories\Eloquent\UserRepository'
        );

        $this->app->bind(
            'App\Repositories\ProfileRepositoryInterface',
            'App\Repositories\Eloquent\ProfileRepository'
        );

        $this->app->bind(
            'App\Repositories\TrickRepositoryInterface',
            'App\Repositories\Eloquent\TrickRepository'
        );

        $this->app->bind(
            'App\Repositories\TagRepositoryInterface',
            'App\Repositories\Eloquent\TagRepository'
        );

        $this->app->bind(
            'App\Repositories\CategoryRepositoryInterface',
            'App\Repositories\Eloquent\CategoryRepository'
        );
    }
}
