<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Auth\AuthManager;
use Illuminate\Routing\Redirector;
use App\Repositories\TrickRepositoryInterface;

class TrickOwner
{
    /**
     * Auth manager instance.
     *
     * @var \Illuminate\Auth\AuthManager
     */
    private $auth;

    /**
     * Trick repository instance.
     *
     * @var \App\Repositories\TrickRepositoryInterface
     */
    private $tricks;

    /**
     * Redirector instance.
     *
     * @var \Illuminate\Routing\Redirector
     */
    private $redirect;

    /**
     * Create a new trick owner filter instance.
     *
     * @param \Illuminate\Auth\AuthManager               $auth
     * @param \Illuminate\Routing\Redirector             $redirect
     * @param \App\Repositories\TrickRepositoryInterface $tricks
     */
    public function __construct(
        AuthManager $auth,
        Redirector $redirect,
        TrickRepositoryInterface $tricks
    ) {
        $this->auth = $auth;
        $this->tricks = $tricks;
        $this->redirect = $redirect;
    }

    /**
     * Execute the route filter.
     *
     * @param \Illuminate\Routing\Route $route
     *
     * @return void|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next)
    {
        $slug = $this->getSlug($request->route());
        $userId = $this->getUserId();

        if (!$this->isTrickOwnedByUser($slug, $userId)) {
            return $this->redirect->route('browse.recent');
        }

        return $next($request);
    }

    /**
     * Get the id of the currently authenticated user.
     *
     * @return int
     */
    protected function getUserId()
    {
        return $this->auth->user()->id;
    }

    /**
     * Get the slug of the trick being edited / deleted.
     *
     * @param \Illuminate\Routing\Route $route
     *
     * @return string
     */
    protected function getSlug($route)
    {
        return $route->getParameter('trick_slug');
    }

    /**
     * Determine whether the user owns the trick.
     *
     * @param string $slug
     * @param int    $userId
     *
     * @return bool
     */
    protected function isTrickOwnedByUser($slug, $userId)
    {
        return $this->tricks->isTrickOwnedByUser($slug, $userId);
    }
}
