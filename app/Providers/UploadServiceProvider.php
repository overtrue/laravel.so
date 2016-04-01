<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Upload\ImageUploadService;

class UploadServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->app['upload.image'] = $this->app->share(function ($app) {
            return new ImageUploadService($app['files']);
        });
    }
}
