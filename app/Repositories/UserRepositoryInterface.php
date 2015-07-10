<?php

namespace App\Repositories;

use App\User;
use Laravel\Socialite\AbstractUser as OAuthUser;

interface UserRepositoryInterface
{
    /**
     * Find all users paginated.
     *
     * @param int $perPage
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator|\User[]
     */
    public function findAllPaginated($perPage = 200);

    /**
     * Find a user by it's username.
     *
     * @param string $username
     *
     * @return \App\User
     */
    public function findByUsername($username);

    /**
     * Find a user by it's email.
     *
     * @param string $email
     *
     * @return \App\User
     */
    public function findByEmail($email);

    /**
     * Require a user by it's username.
     *
     * @param string $username
     *
     * @return \App\User
     *
     * @throws \App\Exceptions\UserNotFoundException
     */
    public function requireByUsername($username);

    /**
     * Create a new user in the database.
     *
     * @param array $data
     *
     * @return \App\User
     */
    public function create(array $data);

    /**
     * Create a new user in the database using GitHub data.
     *
     * @param array $data
     *
     * @return \App\User
     */
    public function createFromGithubData(OAuthUser $data);

    /**
     * Update the user's settings.
     *
     * @param array $data
     *
     * @return \App\User
     */
    public function updateSettings(User $user, array $data);
}
