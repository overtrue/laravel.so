<?php

namespace App\Repositories;

use App\User;
use App\Profile;
use Laravel\Socialite\AbstractUser as OAuthUser;

interface ProfileRepositoryInterface
{
    /**
     * Find a profile by it's UID.
     *
     * @param string $uid
     *
     * @return \App\Profile
     */
    public function findByUid($uid);

    /**
     * Create a new profile from Github data.
     *
     * @param \Laravel\Socialite\AbstractUser $userDetails
     * @param \App\User                           $user
     * @param string                              $token
     *
     * @return \App\Profile
     */
    public function createFromGithubData(OAuthUser $details, User $user, $token);

    /**
     * Update the access token on the profile.
     *
     * @param \App\Profile $profile
     * @param string       $token
     *
     * @return \App\Profile
     */
    public function updateToken(Profile $profile, $token);
}
