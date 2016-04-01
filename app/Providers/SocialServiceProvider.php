<?php

namespace App\Providers;

use App\Services\Social\Github;
use App\Services\Social\Disqus;
use App\Services\Social\Duoshuo;
use Illuminate\Support\ServiceProvider;
use Guzzle\Service\Client as GuzzleClient;

class SocialServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->registerGithub();
//        $this->registerDuoshuo();
        $this->registerDisqus();
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
     * Register the Disqus services.
     */
    protected function registerDisqus()
    {
        $this->app['disqus'] = $this->app->share(function ($app) {
            $config = $app['Illuminate\Config\Repository'];
            $guzzle = new GuzzleClient($config->get('social.disqus.requestUrl'));

            return new Disqus($guzzle, $config);
        });
    }
}
