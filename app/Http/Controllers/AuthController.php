<?php

namespace App\Http\Controllers;

use URL;
use Config;
use App\User;
use Socialite;
use Validator;
use App\Services\Social\Github;
use Illuminate\Auth\Guard;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepositoryInterface;
use App\Exceptions\GithubEmailNotVerifiedException;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends BaseController
{
    /*
        |--------------------------------------------------------------------------
        | Registration & Login Controller
        |--------------------------------------------------------------------------
        |
        | This controller handles the registration of new users, as well as the
        | authentication of existing users. By default, this controller uses
        | a simple trait to add these behaviors. Why don't you explore it?
        |
    */

    use AuthenticatesAndRegistersUsers;

    /**
     * Request.
     *
     * @var \Illuminate\Http\Request
     */
    protected $request;

    /**
     * Users
     *
     * @var UserRepositoryInterface
     */
    protected $users;

    /**
     * Create a new authentication controller instance.
     */
    public function __construct(Request $request, UserRepositoryInterface $users)
    {
        $this->reqeust = $request;
        $this->users = $users;
        $this->middleware('guest', ['except' => 'getLogout']);
    }

    /**
     * Login.
     *
     * @return Response
     */
    public function getLogin()
    {
        return view('home.login');
    }

    /**
     * Post login form.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postLogin(Request $request, Guard $auth)
    {
        $credentials = $request->only(['username', 'password']);
        $remember    = $request->get('remember', false);

        if (str_contains($credentials['username'], '@')) {
            $credentials['email'] = $credentials['username'];
            unset($credentials['username']);
        }

        if ($auth->attempt($credentials, $remember)) {
            return $this->redirectIntended(route('user.index'));
        }

        return $this->redirectBack(['login_errors' => true]);
    }

    /**
     * Register.
     *
     * @return Response
     */
    public function getRegister()
    {
        return view('home.register');
    }

    /**
     * Post registration form.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postRegister(Guard $auth)
    {
        $form = $this->users->getRegistrationForm();

        if (! $form->isValid()) {
            return $this->redirectBack([ 'errors' => $form->getErrors() ]);
        }

        if ($user = $this->users->create($form->getInputData())) {
            $auth->login($user);

            return $this->redirectRoute('user.index', [], ['first_use' => true]);
        }

        return $this->redirectRoute('home');
    }

    /**
     * Handle Github login.
     *
     * @param \App\Facades\Github    $github
     * @param \Illuminate\Auth\Guard $auth
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getLoginWithGithub(Github $github, Guard $auth)
    {
        if (! $this->reqeust->has('state')) {
            session()->keep(['url']);
            Config::set('services.github.redirect', URL::full());

            return Socialite::driver('github')->redirect();
        } else {
            try {
                $user = $github->register(Socialite::driver('github')->user());
                $auth->login($user);

                if (session()->get('password_required')) {
                    return $this->redirectRoute('user.settings', [], [
                        'update_password' => true
                    ]);
                }

                return $this->redirectIntended(route('user.index'));
            } catch (GithubEmailNotVerifiedException $e) {
                return $this->redirectRoute('auth.register', [
                    'github_email_not_verified' => true
                ]);
            }
        }
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     *
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }
}
