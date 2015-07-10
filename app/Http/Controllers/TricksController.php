<?php

namespace App\Http\Controllers;

use Duoshuo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Response;
use App\Repositories\TrickRepositoryInterface;

class TricksController extends BaseController
{
    /**
     * Trick repository.
     *
     * @var \App\Repositories\TrickRepositoryInterface
     */
    protected $tricks;

    /**
     * Create a new TricksController instance.
     *
     * @param \App\Repositories\TrickRepositoryInterface $tricks
     */
    public function __construct(TrickRepositoryInterface $tricks)
    {
        parent::__construct();

        $this->tricks = $tricks;
    }

    /**
     * Show the single trick page.
     *
     * @param string $slug
     *
     * @return \Response
     */
    public function getShow($slug = null)
    {
        if (is_null($slug)) {
            return $this->redirectIntended('/');
        }

        $trick = $this->tricks->findBySlug($slug);

        if (is_null($trick)) {
            return $this->redirectIntended('/');
        }

        Event::fire('trick.view', $trick);

        $next = $this->tricks->findNextTrick($trick);
        $prev = $this->tricks->findPreviousTrick($trick);

        return view('tricks.single', compact('trick', 'next', 'prev'));
    }

    /**
     * Handle the liking of a trick.
     *
     * @param string $slug
     *
     * @return \Response
     */
    public function postLike(Request $request, $slug)
    {
        if (!$request->ajax() || !Auth::check()) {
            $this->redirectRoute('browse.recent');
        }

        $trick = $this->tricks->findBySlug($slug);

        if (is_null($trick)) {
            return Response::make('error', 404);
        }

        $user = Auth::user();

        $voted = $trick->votes()->whereUserId($user->id)->first();

        if (!$voted) {
            $user = $trick->votes()->attach($user->id, [
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime(),
            ]);
            $trick->vote_cache = $trick->vote_cache + 1;
        } else {
            $trick->votes()->detach($voted->id);
            $trick->vote_cache = $trick->vote_cache - 1;
        }

        $trick->save();

        return Response::make($trick->vote_cache, 200);
    }

    /**
     * Get Duoshuo comments counts.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function getCommentCounts(Request $request)
    {
        if (count($request->threads) <= 0) {
            return [];
        }

        return response()->json(Duoshuo::getCommentCountsByIds($request->threads));
    }
}
