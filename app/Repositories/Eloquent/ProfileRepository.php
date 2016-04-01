<?php

namespace App\Repositories\Eloquent;

use App\User;
use App\Profile;
use App\Repositories\ProfileRepositoryInterface;
use Laravel\Socialite\AbstractUser as OAuthUser;

class ProfileRepository extends AbstractRepository implements ProfileRepositoryInterface
{
    /**
     * Create a new DbProfileRepository instance.
     *
     * @param \App\Profile $profile
     */
    public function __construct(Profile $profile)
    {
        $this->model = $profile;
    }

    /**
     * Find a profile by it's UID.
     *
     * @param string $uid
     *
     * @return \App\Profile
     */
    public function findByUid($uid)
    {
        return $this->model->whereUid($uid)->first();
    }

    /**
     * Create a new profile from Github data.
     *
     * @param \Laravel\Socialite\AbstractUser $userDetails
     * @param \App\User                           $user
     * @param string                              $token
     *
     * @return \App\Profile
     */
    public function createFromGithubData(OAuthUser $details, User $user, $token)
    {
        $profile = $this->getNew();

        $profile->uid = $details->getId();
        $profile->username = $details->getNickname();
        $profile->name = $details->getName();
        $profile->email = $details->getEmail();
        $profile->location = $details['location'];
        $profile->description = $details['blog'];
        $profile->image_url = $details->getAvatar();
        $profile->access_token = $details->token;
        $profile->user_id = $user->id;

        $profile->save();

        return $profile;
    }

    /**
     * Update the access token on the profile.
     *
     * @param \App\Profile $profile
     * @param string       $token
     *
     * @return \App\Profile
     */
    public function updateToken(Profile $profile, $token)
    {
        $profile->access_token = $token;
        $profile->save();

        return $profile;
    }
}
