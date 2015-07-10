<?php

namespace App\Services\Social;

use Socialite;
use Illuminate\Config\Repository;
use App\Repositories\UserRepositoryInterface;
use App\Repositories\ProfileRepositoryInterface;
use App\Exceptions\GithubEmailNotVerifiedException;

class Github
{
    /**
     * Profile repository.
     *
     * @var \App\Repositories\ProfileRepositoryInterface
     */
    protected $profiles;

    /**
     * User repository.
     *
     * @var \App\Repositories\UserRepositoryInterface
     */
    protected $users;

    /**
     * Create a new Github registration instance.
     *
     * @param \App\Repositories\UserRepositoryInterface    $users
     * @param \App\Repositories\ProfileRepositoryInterface $profiles
     */
    public function __construct(
        UserRepositoryInterface $users,
        ProfileRepositoryInterface $profiles
    ) {
        $this->users = $users;
        $this->profiles = $profiles;
    }

    /**
     * Register a new user using their Github account.
     *
     * @param string $code
     *
     * @return \App\User
     */
    public function register($userDetails)
    {
        $userDetails->email = $userDetails->getEmail();

        $profile = $this->profiles->findByUid($userDetails->getId());

        if (is_null($profile)) {
            $user = $this->users->findByEmail($userDetails->email);

            if (is_null($user)) {
                $user = $this->users->createFromGithubData($userDetails);
            }

            $profile = $this->profiles->createFromGithubData($userDetails, $user, $userDetails->token);
        } else {
            $profile = $this->profiles->updateToken($profile, $userDetails->token);
            $user = $profile->user;
        }

        return $user;
    }
}
