<?php

namespace App;

use App\Presenters\TrickPresenter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use McCool\LaravelAutoPresenter\HasPresenter;

class Trick extends Model implements HasPresenter
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tricks';

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['tags', 'categories', 'user'];

    /**
     * Query the tricks' votes.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function votes()
    {
        return $this->belongsToMany(User::class, 'votes');
    }

    /**
     * Query the user that posted the trick.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Query the tags under which the trick was posted.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    /**
     * Query the categories under which the trick was posted.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    /**
     * Filter the draft of tricks.
     *
     * @param $query
     * @return mixed
     */
    public function scopeNotDraft($query)
    {
        return $query->where('is_draft', 0);
    }

    public function getPresenterClass()
    {
        return TrickPresenter::class;
    }
}
