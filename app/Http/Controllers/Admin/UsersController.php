<?php

namespace Controllers\Admin;

use Controllers\BaseController;
use App\Repositories\UserRepositoryInterface;

class UsersController extends BaseController
{
    /**
     * User repository.
     *
     * @var \App\Repositories\UserRepositoryInterface
     */
    protected $users;

    /**
     * Create a new UsersController instance.
     *
     * @param \App\Repositories\UserRepositoryInterface $users
     */
    public function __construct(UserRepositoryInterface $users)
    {
        parent::__construct();

        $this->users = $users;
    }

    /**
     * Show the users index page.
     *
     * @return \Response
     */
    public function getIndex()
    {
        $users = $this->users->findAllPaginated();

        return view('admin.users.list', compact('users'));
    }
}
