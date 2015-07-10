<?php

namespace App\Http\Controllers;

use App\Repositories\TagRepositoryInterface;
use App\Repositories\TrickRepositoryInterface;
use App\Repositories\CategoryRepositoryInterface;

class BrowseController extends BaseController
{
    /**
     * Category repository.
     *
     * @var \App\Repositories\CategoryRepositoryInterface
     */
    protected $categories;

    /**
     * Tags repository.
     *
     * @var \App\Repositories\TagRepositoryInterface
     */
    protected $tags;

    /**
     * Trick repository.
     *
     * @var \App\Repositories\TrickRepositoryInterface
     */
    protected $tricks;

    /**
     * Create a new BrowseController instance.
     *
     * @param \App\Repositories\CategoryRepositoryInterface $categories
     * @param \App\Repositories\TagRepositoryInterface      $tags
     * @param \App\Repositories\TrickRepositoryInterface    $tricks
     */
    public function __construct(
        CategoryRepositoryInterface $categories,
        TagRepositoryInterface $tags,
        TrickRepositoryInterface $tricks
    ) {
        parent::__construct();

        $this->categories = $categories;
        $this->tags = $tags;
        $this->tricks = $tricks;
    }

    /**
     * Show the categories index.
     *
     * @return \Response
     */
    public function getCategoryIndex()
    {
        $categories = $this->categories->findAllWithTrickCount();

        return view('browse.categories', compact('categories'));
    }

    /**
     * Show the browse by category page.
     *
     * @param string $category
     *
     * @return \Response
     */
    public function getBrowseCategory($category)
    {
        list($category, $tricks) = $this->tricks->findByCategory($category);

        $type = trans('browse.category', array('category' => $category->name));
        $pageTitle = trans('browse.browsing_category', array('category' => $category->name));

        return view('browse.index', compact('tricks', 'type', 'pageTitle'));
    }

    /**
     * Show the tags index.
     *
     * @return \Response
     */
    public function getTagIndex()
    {
        $tags = $this->tags->findAllWithTrickCount();

        return view('browse.tags', compact('tags'));
    }

    /**
     * Show the browse by tag page.
     *
     * @param string $tag
     *
     * @return \Response
     */
    public function getBrowseTag($tag)
    {
        list($tag, $tricks) = $this->tricks->findByTag($tag);

        $type = trans('browse.tag', array('tag' => $tag->name));
        $pageTitle = trans('browse.browsing_tag', array('tag' => $tag->name));

        return view('browse.index', compact('tricks', 'type', 'pageTitle'));
    }

    /**
     * Show the browse recent tricks page.
     *
     * @return \Response
     */
    public function getBrowseRecent()
    {
        $tricks = $this->tricks->findMostRecent();

        $type = trans('browse.recent');
        $pageTitle = trans('browse.browsing_most_recent_tricks');

        return view('browse.index', compact('tricks', 'type', 'pageTitle'));
    }

    /**
     * Show the browse popular tricks page.
     *
     * @return \Response
     */
    public function getBrowsePopular()
    {
        $tricks = $this->tricks->findMostPopular();

        $type = trans('browse.popular');
        $pageTitle = trans('browse.browsing_most_popular_tricks');

        return view('browse.index', compact('tricks', 'type', 'pageTitle'));
    }

    /**
     * Show the browse most commented tricks page.
     *
     * @return \Response
     */
    public function getBrowseComments()
    {
        $tricks = $this->tricks->findMostCommented();

        $type = trans('browse.most_commented');
        $pageTitle = trans('browse.browsing_most_commented_tricks');

        return view('browse.index', compact('tricks', 'type', 'pageTitle'));
    }
}
