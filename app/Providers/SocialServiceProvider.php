<?php

namespace App\Providers;

use App\Services\Social\Github;
use App\Services\Social\Duoshuo;
use Illuminate\Support\ServiceProvider;
use GuzzleHttp\Client as GuzzleClient;

class SocialServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->registerGithub();
        $this->registerDuoshuo();
    }

    /**
     * Register the Github services.
     */
    protected function registerGithub()
    {
        $this->app['github'] = $this->app->share(function ($app) {
            $users = $app['App\Repositories\UserRepositoryInterface'];
            $profiles = $app['App\Repositories\ProfileRepositoryInterface'];

            return new Github($users, $profiles);
        });
    }

    /**
     * Register the Duoshuo services.
     */
    protected function registerDuoshuo()
    {
        $this->app['duoshuo'] = $this->app->share(function ($app) {
            $config = $app['Illuminate\Config\Repository'];
            $guzzle = new GuzzleClient(['base_uri' => $config->get('services.duoshuo.base_uri')]);

            return new Duoshuo($guzzle, $config);
        });
    }
}
