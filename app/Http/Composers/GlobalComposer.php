<?php

namespace App\Http\Composers;

use Auth;
use App\Presenters\UserPresenter;
use App\Link;
use Cache;
use Illuminate\Support\Fluent;

class GlobalComposer
{
    public function compose($view)
    {
        $frontend = new Fluent();

        if (Auth::check()) {
            $frontend->user = new UserPresenter(Auth::user());
        }

        $frontend->links = Cache::get('links', function(){
            $links = least('array', [Link::all()->toArray(), []]);

            Cache::put('links', $links, 60000);

            return $links;
        });

        $view->with('frontend', $frontend);
    }
}
