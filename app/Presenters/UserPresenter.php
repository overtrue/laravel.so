<?php

namespace App\Presenters;

use Gravatar;
use App\User;
use McCool\LaravelAutoPresenter\BasePresenter;

class UserPresenter extends BasePresenter
{
    /**
     * Create a new UserPresenter instance.
     *
     * @param \App\User $resource
     */
    public function __construct(User $resource)
    {
        $this->wrappedObject = $resource;
    }

    /**
     * Get the timestamp of the last posted trick of this user.
     *
     * @param \Illuminate\Pagination\Paginator $tricks
     *
     * @return string
     */
    public function lastActivity($tricks)
    {
        if (count($tricks) == 0) {
            return 'No activity';
        }

        $collection = $tricks->getCollection();
        $sorted = $collection->sortBy(function ($trick) {
            return $trick->created_at;
        })->reverse();

        $last = $sorted->first();

        return $last->created_at->diffForHumans();
    }

    /**
     * Get the full name of this user.
     *
     * @return string
     */
    public function fullName()
    {
        $profile = $this->wrappedObject->profile;

        if (!is_null($profile) && !empty($profile->name)) {
            return $profile->name;
        }

        return $this->wrappedObject->username;
    }


    /**
     * Get the user's avatar image.
     *
     * @return string
     */
    public function avatar()
    {
        if (false != stripos($this->photo, 'http://')
            || false !== stripos($this->photo, 'https://')) {
            return $this->photo;
        }

        if ($this->photo) {
            return url('img/avatar/'.$this->photo);
        }

        return Gravatar::src($this->email, 100);
    }
}
