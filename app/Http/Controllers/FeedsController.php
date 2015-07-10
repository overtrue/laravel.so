<?php

namespace App\Http\Controllers;

use App\Services\Feeds\Builder;

class FeedsController extends BaseController
{
    /**
     * Feed builder instance.
     *
     * @var \App\Services\Feeds\Builder
     */
    protected $builder;

    /**
     * Create a new FeedsController instance.
     *
     * @param \App\Services\Feeds\Builder $builder
     */
    public function __construct(Builder $builder)
    {
        parent::__construct();

        $this->builder = $builder;
    }

    /**
     * Show the ATOM feed.
     *
     * @return \Response
     */
    public function getAtom()
    {
        return $this->builder->render('atom');
    }

    /**
     * Show the RSS feed.
     *
     * @return \Response
     */
    public function getRss()
    {
        return $this->builder->render('rss');
    }
}
