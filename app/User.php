<?php

namespace App;

use App\Presenters\UserPresenter;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use McCool\LaravelAutoPresenter\HasPresenter;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract, HasPresenter
{
    use Authenticatable, CanResetPassword, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['password'];

    /**
     * Users should not be admin by default.
     *
     * @var array
     */
    protected $attributes = [
        'is_admin' => false,
    ];

    /**
     * Query the user's social profile.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    /**
     * Query the tricks that the user has posted.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tricks()
    {
        return $this->hasMany(Trick::class);
    }

    /**
     * Query the votes that are casted by the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function votes()
    {
        return $this->belongsToMany(Trick::class, 'votes');
    }

    /**
     * Check user's permissions.
     *
     * @return bool
     */
    public function isAdmin()
    {
        return ($this->is_admin == true);
    }

    public function getPresenterClass()
    {
        return UserPresenter::class;
    }
}
