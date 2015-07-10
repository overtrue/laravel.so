<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;

class BaseController extends Controller
{
    /**
     * Create a new BaseController instance.
     */
    public function __construct()
    {
        $this->middleware('csrf', ['on' => 'post']);
    }

    /**
     * Redirect to the specified named route.
     *
     * @param string $route
     * @param array  $params
     * @param array  $data
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function redirectRoute($route, $params = [], $data = [])
    {
        return Redirect::route($route, $params)->with($data);
    }

    /**
     * Redirect back with old input and the specified data.
     *
     * @param array $data
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function redirectBack($data = [])
    {
        return Redirect::back()->withInput()->with($data);
    }

    /**
     * Redirect a logged in user to the previously intended url.
     *
     * @param mixed $default
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function redirectIntended($default = null)
    {
        return Redirect::intended($default);
    }
}
