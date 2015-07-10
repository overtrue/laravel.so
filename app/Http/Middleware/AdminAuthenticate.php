<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use URL;

class AdminAuthenticate
{
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * 排除项.
     *
     * @var array
     */
    protected $except = ['*auth/login'];

    /**
     * Create a new filter instance.
     *
     * @param Guard $auth
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($this->shouldPassThrough($request)) {
            return $next($request);
        }

        if ($this->auth->guest()) {
            if ($request->ajax()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect()->guest(admin_url('auth/login?redirect='.URL::full()));
            }
        }

        if (!$this->auth->user()->is_admin) {
            exit('403');
        }

        return $next($request);
    }

    public function shouldPassThrough($request)
    {
        foreach ($this->except as $uri) {
            if ($request->is($uri)) {
                return true;
            }
        }

        return false;
    }
}
