<?php

namespace App\Http\Controllers;

use App\Services\Sitemap\Builder;

class SitemapController extends BaseController
{
    /**
     * Sitemap builder instance.
     *
     * @var \App\Services\Sitemap\Builder
     */
    protected $builder;

    /**
     * Create a new SitemapController instance.
     *
     * @param \App\Services\Sitemap\Builder $builder
     */
    public function __construct(Builder $builder)
    {
        parent::__construct();

        $this->builder = $builder;
    }

    /**
     * Show the sitemap.
     */
    public function getIndex()
    {
        return $this->builder->render();
    }
}
