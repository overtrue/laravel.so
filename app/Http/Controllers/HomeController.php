<?php

namespace App\Http\Controllers;

use App\Repositories\TrickRepositoryInterface;

class HomeController extends BaseController
{
    /**
     * Trick repository.
     *
     * @var \App\Repositories\TrickRepositoryInterface
     */
    protected $tricks;

    /**
     * Create a new HomeController instance.
     *
     * @param \App\Repositories\TrickRepositoryInterface $tricks
     */
    public function __construct(TrickRepositoryInterface $tricks)
    {
        parent::__construct();

        $this->tricks = $tricks;
    }

    /**
     * Show the homepage.
     *
     * @return \Response
     */
    public function getIndex()
    {
        $tricks = $this->tricks->findAllPaginated();

        return view('home.index', compact('tricks'));
    }

    /**
     * Show the about page.
     *
     * @return \Response
     */
    public function getAbout()
    {
        return view('home.about');
    }
}
