<?php

namespace App\Listeners;

use Illuminate\Session\Store;
use App\Repositories\TrickRepositoryInterface;

class ViewTrickListener
{
    /**
     * Trick repository instance.
     *
     * @var \App\Repositories\TrickRepositoryInterface
     */
    protected $tricks;

    /**
     * Session store instance.
     *
     * @var \Illuminate\Session\Store
     */
    protected $session;

    /**
     * Create a new view trick handler instance.
     *
     * @param \App\Repositories\TrickRepositoryInterface $tricks
     * @param \Illuminate\Session\Store                  $session
     */
    public function __construct(TrickRepositoryInterface $tricks, Store $session)
    {
        $this->tricks = $tricks;
        $this->session = $session;
    }

    /**
     * Handle the view trick event.
     *
     * @param \App\Trick $trick
     */
    public function handle($trick)
    {
        if (!$this->hasViewedTrick($trick)) {
            $trick = $this->tricks->incrementViews($trick);

            $this->storeViewedTrick($trick);
        }
    }

    /**
     * Determine whether the user has viewed the trick.
     *
     * @param \App\Trick $trick
     *
     * @return bool
     */
    protected function hasViewedTrick($trick)
    {
        return array_key_exists($trick->id, $this->getViewedTricks());
    }

    /**
     * Get the users viewed trick from the session.
     *
     * @return array
     */
    protected function getViewedTricks()
    {
        return $this->session->get('viewed_tricks', []);
    }

    /**
     * Append the newly viewed trick to the session.
     *
     * @param \App\Trick $trick
     */
    protected function storeViewedTrick($trick)
    {
        $key = 'viewed_tricks.'.$trick->id;

        $this->session->put($key, time());
    }
}
