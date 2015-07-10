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
        View::composer(['admin.hospital.form', 'admin.disease.form', 'index', 'hospital.*', 'doctor.*', 'examination.*', 'page.assess'], 'App\Http\Composers\DepartmentsComposer');
    }

    /**
     * Register.
     */
    public function register()
    {
        //
    }
}
