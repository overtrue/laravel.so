<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class SitemapServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->app->alias('sitemap', 'Roumen\Sitemap\Sitemap');
    }
}
