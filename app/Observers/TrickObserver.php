<?php

namespace App\Observers;

use App\Trick;

/**
 * Trick模型观察者.
 *
 * @author overtrue <anzhengchao@gmail.com>
 */
class TrickObserver
{
    public function creating(Trick $trick)
    {
        $trick->slug = md5($trick->title);
    }

    public function saving()
    {
        # code...
    }

    public function created()
    {
        # code...
    }
}
