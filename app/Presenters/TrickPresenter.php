<?php

namespace App\Presenters;

use App\User;
use App\Trick;
use App\Category;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\URL;
use Illuminate\Html\HtmlFacade as HTML;
use McCool\LaravelAutoPresenter\BasePresenter;
use Naux\AutoCorrect;

class TrickPresenter extends BasePresenter
{
    /**
     * Cache for whether the user has liked this trick.
     *
     * @var bool
     */
    protected $likedByUser = null;

    /**
     * Create a new TrickPresenter instance.
     *
     * @param \App\Trick $resource
     */
    public function __construct(Trick $resource)
    {
        $this->wrappedObject = $resource;
    }

    /**
     * Get the edit link for this trick.
     *
     * @return string
     */
    public function editLink()
    {
        return URL::route('tricks.edit', [$this->wrappedObject->slug]);
    }

    /**
     * Get the delete link for this trick.
     *
     * @return string
     */
    public function deleteLink()
    {
        return URL::route('tricks.delete', [$this->wrappedObject->slug]);
    }

    /**
     * Get a readable created timestamp.
     *
     * @return string
     */
    public function timeago()
    {
        return $this->wrappedObject->created_at->diffForHumans();
    }

    /**
     * Returns whether the given user has liked this trick.
     *
     * @param \App\User $user
     *
     * @return bool
     */
    public function likedByUser($user)
    {
        if (is_null($user)) {
            return false;
        }

        if (is_null($this->likedByUser)) {
            $this->likedByUser = $this->wrappedObject
                                      ->votes()
                                      ->where('users.id', $user->id)
                                      ->exists();
        }

        return $this->likedByUser;
    }

    /**
     * Get all the categories for this trick.
     *
     * @return \Illuminate\Database\Eloquent\Collection|\App\Category[]
     */
    public function allCategories()
    {
        return $this->wrappedObject->categories;
    }

    /**
     * List the categories which this trick is in.
     *
     * @return string
     */
    public function categories()
    {
        $result = '';

        if ($this->hasCategories()) {
            $categories = [];

            foreach ($this->wrappedObject->categories as $category) {
                $categories[] = $this->getCategoryLink($category);
            }

            $result = '于 '.implode(', ', $categories);
        }

        return $result;
    }

    /**
     * Determine whether the trick has any categories.
     *
     * @return bool
     */
    protected function hasCategories()
    {
        return isset($this->wrappedObject->categories) && count($this->wrappedObject->categories) > 0;
    }

    /**
     * Get a HTML link to the given category.
     *
     * @param \App\Category $category
     *
     * @return string
     */
    protected function getCategoryLink(Category $category)
    {
        return HTML::linkRoute('tricks.browse.category', $category->name, [$category->slug]);
    }

    /**
     * Get the meta content for this trick.
     *
     * @return string
     */
    public function pageDescription()
    {
        $content = $this->wrappedObject->content;
        $maxLength = 160;
        $content = str_replace(['"', "\n", "\r", "#", "```php", "```"], '', $content);

        if (strlen($content) > $maxLength) {
            while (strlen($content) + 3 > $maxLength) {
                $content = $this->removeLastWord($content);
            }

            $content .= '...';
        }

        return $content;
    }

    // /**
    //  * Get the author name of this tirck.
    //  *
    //  * // XXX: weibo username is useful. :(
    //  *
    //  * @return string
    //  */
    // public function trickAuthor()
    // {
    //     if ($this->wrappedObject->user->profile
    //         && $this->wrappedObject->user->profile->username) {
    //         return $this->wrappedObject->user->profile->username;
    //     }

    //     return $this->wrappedObject->user->username;
    // }

    /**
     * Get the meta title for this trick.
     *
     * @return string
     */
    public function pageTitle()
    {
        $title = $this->wrappedObject->title;
        $baseTitle = ' ・ Laravel.so';
        $maxLength = 70;

        if (strlen($title.$baseTitle) > $maxLength) {
            while (strlen($title.$baseTitle) > $maxLength) {
                $title = $this->removeLastWord($title);
            }
        }

        return e($title);
    }

    /**
     * Get the correct title for this trick.
     *
     * @return string
     */
    public function title()
    {
        return app('AutoCorrect')->convert($this->getWrappedObject()->title);
    }

    /**
     * Remove the last word from a given string.
     *
     * @param string $string
     *
     * @return string
     */
    protected function removeLastWord($string)
    {
        $split = explode(' ', $string);

        array_pop($split);

        return implode(' ', $split);
    }

    /**
     * Get the tag URI for this trick.
     *
     * @return string
     */
    public function tagUri()
    {
        $url = parse_url(route('tricks.show', $this->wrappedObject->slug));

        $output = 'tag:';
        $output .= $url['host'].',';
        $output .= $this->wrappedObject->created_at->format('Y-m-d').':';
        $output .= $url['path'];

        return $output;
    }
}
