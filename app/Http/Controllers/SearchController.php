<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use App\Repositories\TrickRepositoryInterface;

class SearchController extends BaseController
{
    /**
     * Trick repository.
     *
     * @var \App\Repositories\TrickRepositoryInterface
     */
    protected $tricks;

    /**
     * Create a new SearchController instance.
     *
     * @param \App\Repositories\TrickRepositoryInterface $tricks
     */
    public function __construct(TrickRepositoryInterface $tricks)
    {
        parent::__construct();

        $this->tricks = $tricks;
    }

    /**
     * Show the search results page.
     *
     * @return \Response
     */
    public function getIndex()
    {
        $term = e(Input::get('q'));
        $tricks = null;

        if (!empty($term)) {
            $tricks = $this->tricks->searchByTermPaginated($term, 12);
        }

        return view('search.result', compact('tricks', 'term'));
    }
}
