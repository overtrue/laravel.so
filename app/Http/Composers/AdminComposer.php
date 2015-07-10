<?php

namespace App\Http\Composers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Fluent;
use Auth;

/**
 * 后台视图组织.
 *
 * @author rongyouyuan <rongyouyuan@163.com>
 */
class AdminComposer
{
    /**
     * request.
     *
     * @var Illuminate\Http\Request
     */
    private $request;

    /**
     * accountService.
     *
     * @var App\Services\Account;
     */
    private $accountService;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * compose.
     *
     * @param View $view 视图对象
     */
    public function compose(View $view)
    {
        $menus = config('menu');

        $global = new Fluent();

        $global->user = Auth::user();

        $global->menus = $menus;

        $view->with('global', $global);
    }
}
