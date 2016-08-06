<?php

namespace App\Http\Controllers;

use ImageUpload;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use App\Repositories\TrickRepositoryInterface;
use App\Repositories\UserRepositoryInterface;

class UserController extends BaseController
{
    /**
     * Trick repository.
     *
     * @var \App\Repositories\TrickRepositoryInterface
     */
    protected $tricks;

    /**
     * User repository.
     *
     * @var \App\Repositories\UserRepositoryInterface
     */
    protected $users;

    /**
     * The currently authenticated user.
     *
     * @var \User
     */
    protected $user;

    /**
     * Create a new UserController instance.
     *
     * @param \App\Repositories\TrickRepositoryInterface $tricks
     * @param \App\Repositories\UserRepositoryInterface  $users
     */
    public function __construct(TrickRepositoryInterface $tricks, UserRepositoryInterface $users)
    {
        parent::__construct();

        $this->beforeFilter('auth', ['except' => 'getPublic']);

        $this->user = Auth::user();
        $this->tricks = $tricks;
        $this->users = $users;
    }

    /**
     * Show the user's tricks page.
     *
     * @return \Response
     */
    public function getIndex()
    {
        $tricks = $this->tricks->findAllForUser($this->user, 12);

        return view('user.profile', compact('tricks'));
    }

    /**
     * Show the settings page.
     *
     * @return \Response
     */
    public function getSettings()
    {
        return view('user.settings');
    }

    /**
     * Show the favorited tricks page.
     *
     * @return \Response
     */
    public function getFavorites()
    {
        $tricks = $this->tricks->findAllFavorites($this->user);

        return view('user.favorites', compact('tricks'));
    }

    /**
     * Handle the settings form.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postSettings()
    {
        $form = $this->users->getSettingsForm();

        if (!$form->isValid()) {
            return $this->redirectBack(['errors' => $form->getErrors()]);
        }

        $this->users->updateSettings($this->user, Input::all());

        return $this->redirectRoute('user.settings', [], ['settings_updated' => true]);
    }

    /**
     * Handle the avatar upload.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function postAvatar()
    {
        if (isset($_SERVER['HTTP_ORIGIN'])) {
            ImageUpload::enableCORS($_SERVER['HTTP_ORIGIN']);
        }

        if (Request::server('REQUEST_METHOD') == 'OPTIONS') {
            exit;
        }

        $json = ImageUpload::handle(Input::file('filedata'));

        if ($json !== false) {
            return Response::json($json, 200);
        }

        return Response::json('error', 400);
    }

    /**
     * Show the user's public profile page.
     *
     * @param string $username
     *
     * @return \Response
     */
    public function getPublic($username)
    {
        $user = $this->users->requireByUsername($username);
        $tricks = $this->tricks->findAllForUser($user, 9, true);

        return view('user.public', compact('user', 'tricks'));
    }
}
