<?php

namespace App\Http;

use App\Http\Middleware\TrickOwner;
use App\Http\Middleware\ViewThrottle;
use App\Http\Middleware\Authenticate;
use App\Http\Middleware\EncryptCookies;
use App\Http\Middleware\VerifyCsrfToken;
use App\Http\Middleware\AdminAuthenticate;
use Illuminate\Session\Middleware\StartSession;
use App\Http\Middleware\RedirectIfAuthenticated;
use Illuminate\Foundation\Http\Kernel as HttpKernel;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Illuminate\Auth\Middleware\AuthenticateWithBasicAuth;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * @var array
     */
    protected $middleware = [
        CheckForMaintenanceMode::class,
        EncryptCookies::class,
        AddQueuedCookiesToResponse::class,
        StartSession::class,
        ShareErrorsFromSession::class,
        ViewThrottle::class,
    ];

    /**
     * The application's route middleware.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => Authenticate::class,
        'csrf' => VerifyCsrfToken::class,
        'admin' => AdminAuthenticate::class,
        'trick.owner' => TrickOwner::class,
        'auth.basic' => AuthenticateWithBasicAuth::class,
        'guest' => RedirectIfAuthenticated::class,
    ];
}
