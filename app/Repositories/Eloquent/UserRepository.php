<?php

namespace App\Repositories\Eloquent;

use App\User;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Exceptions\UserNotFoundException;
use App\Repositories\UserRepositoryInterface;
use Laravel\Socialite\AbstractUser as OAuthUser;

class UserRepository extends AbstractRepository implements UserRepositoryInterface
{
    /**
     * Create a new DbUserRepository instance.
     *
     * @param \App\User $user
     */
    public function __construct(User $user)
    {
        $this->model = $user;
    }

    /**
     * Find all users paginated.
     *
     * @param int $perPage
     *
     * @return Illuminate\Database\Eloquent\Collection|\App\User[]
     */
    public function findAllPaginated($perPage = 200)
    {
        return $this->model
                    ->orderBy('created_at', 'desc')
                    ->paginate($perPage);
    }

    /**
     * Find a user by it's username.
     *
     * @param string $username
     *
     * @return \App\User
     */
    public function findByUsername($username)
    {
        return $this->model->whereUsername($username)->first();
    }

    /**
     * Find a user by it's email.
     *
     * @param string $email
     *
     * @return \App\User
     */
    public function findByEmail($email)
    {
        return $this->model->whereEmail($email)->first();
    }

    /**
     * Require a user by it's username.
     *
     * @param string $username
     *
     * @return \App\User
     *
     * @throws \App\Exceptions\UserNotFoundException
     */
    public function requireByUsername($username)
    {
        if (!is_null($user = $this->findByUsername($username))) {
            return $user;
        }

        throw new UserNotFoundException('The user "'.$username.'" does not exist!');
    }

    /**
     * Create a new user in the database.
     *
     * @param array $data
     *
     * @return \App\User
     */
    public function create(array $data)
    {
        $user = $this->getNew();

        $user->email = e($data['email']);
        $user->username = e($data['username']);
        $user->password = Hash::make($data['password']);
        $user->photo = isset($data['image_url']) ? $data['image_url'] : null;

        $user->save();

        return $user;
    }

    /**
     * Create a new user in the database using GitHub data.
     *
     * @param \Laravel\Socialite\AbstractUser $data
     *
     * @return \App\User
     */
    public function createFromGithubData(OAuthUser $data)
    {
        $user = $this->getNew();

        $username = $data->getNickname();
        $isAvailable = is_null($this->findByUsername($username));
        $isAllowed = $this->usernameIsAllowed($username);

        $user->username = $username;

        if (!$isAvailable or !$isAllowed) {
            $user->username .= '_'.str_random(3);
            Session::flash('username_required', true);
        }

        $user->email = $data->getEmail();
        $user->photo = $data->getAvatar() ?: '';

        $user->save();

        Session::flash('password_required', true);

        return $user;
    }

    /**
     * Returns whether the given username is allowed to be used.
     *
     * @param string $username
     *
     * @return bool
     */
    protected function usernameIsAllowed($username)
    {
        return !in_array(strtolower($username), config('config.forbidden_usernames', []));
    }

    /**
     * Update the user's settings.
     *
     * @param \App\User $user
     * @param array     $data
     *
     * @return \App\User
     */
    public function updateSettings(User $user, array $data)
    {
        $user->username = $data['username'];
        if ($data['password'] != '') {
            $user->password = Hash::make($data['password']);
        }

        if ($data['avatar'] != '') {
            File::move(public_path().'/img/avatar/temp/'.$data['avatar'], 'img/avatar/'.$data['avatar']);

            if ($user->photo) {
                File::delete(public_path().'/img/avatar/'.$user->photo);
            }

            $user->photo = $data['avatar'];
        }

        return $user->save();
    }

    /**
     * Get the user registration form service.
     *
     * @return \App\Services\Forms\RegistrationForm
     */
    public function getRegistrationForm()
    {
        return app('App\Services\Forms\RegistrationForm');
    }

    /**
     * Get the user settings form service.
     *
     * @return \App\Services\Forms\SettingsForm
     */
    public function getSettingsForm()
    {
        return app('App\Services\Forms\SettingsForm');
    }
}
