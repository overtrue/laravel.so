<?php

namespace App\Providers;

use View;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     */
    public function boot()
    {
        // 使用类来指定视图组件
        View::composer('admin.*', 'App\Http\Composers\AdminComposer');
        View::composer('*', 'App\Http\Composers\GlobalComposer');
    }

    /**
     * Register.
     */
    public function register()
    {
        //
    }
}
