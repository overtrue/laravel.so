<?php

namespace App\Http\Controllers\Admin;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

/**
 * 登录.
 */
class AuthController extends Controller
{
    /**
     * 登录页.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function getLogin(Request $request)
    {
        if (Auth::check()) {
            return redirect($request->get('redirect', admin_url('/')));
        }

        return admin_view('auth.login');
    }

    /**
     * Handle a login request to the application.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function postLogin(Request $request)
    {
        $attributes = [
            'name' => '用户名',
            'password' => '密码',
                      ];

        $this->validate($request, [
            'name' => 'required|min:5',
        'password' => 'required',
                                  ], [], $attributes);

        $credentials = $request->only('name', 'password');

        if (Auth::attempt($credentials, $request->has('remember'))) {
            return redirect($request->get('redirect', admin_url('/')));
        }

        return redirect()->back()->withInput($request->except('password'))->withErrors([
                'name' => '用户名或密码错误！',
                                                                                               ]);
    }

    /**
     * 登出.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function getLogout(Request $request)
    {
        Auth::logout();

        return redirect(admin_url('auth/login'))->withMessage('您已经注销登录！');
    }
}
