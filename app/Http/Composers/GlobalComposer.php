<?php

namespace App\Http\Composers;

use Illuminate\Support\Fluent;
use App\Link;

class GlobalComposer
{
    public function compose($view)
    {
        $frontend = new Fluent();

        $frontend->links = least('array', [Link::all()->toArray(), []]);

        $view->with('frontend', $frontend);
    }
}
