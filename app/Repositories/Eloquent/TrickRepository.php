<?php

namespace App\Repositories\Eloquent;

use Auth;
use Disqus;
use App\Tag;
use App\User;
use App\Trick;
use App\Category;
use Illuminate\Support\Str;
use App\Services\Forms\TrickForm;
use App\Services\Forms\TrickEditForm;
use App\Exceptions\TagNotFoundException;
use App\Exceptions\CategoryNotFoundException;
use App\Repositories\TrickRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class TrickRepository extends AbstractRepository implements TrickRepositoryInterface
{
    /**
     * Category model.
     *
     * @var \App\Category
     */
    protected $category;

    /**
     * Tag model.
     *
     * @var \App\Tag
     */
    protected $tag;

    const PAGE_SIZE = 11;

    /**
     * Create a new DbTrickRepository instance.
     *
     * @param \App\Trick    $trick
     * @param \App\Category $category
     * @param \App\Tag      $tag
     */
    public function __construct(Trick $trick, Category $category, Tag $tag)
    {
        $this->model = $trick;
        $this->category = $category;
        $this->tag = $tag;
    }

    /**
     * Find all the tricks for the given user paginated.
     *
     * @param \App\User $user
     * @param int       $perPage
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator|\App\Trick[]
     */
    public function findAllForUser(User $user, $perPage = self::PAGE_SIZE)
    {
        $trick = $this->model;

        if(isset(Auth::user()->id) && Auth::user()->id == $user->id)
            $trick = $trick->withDrafted();

        return $trick->where('user_id', $user->id)
                     ->orderBy('created_at', 'DESC')
                     ->paginate($perPage);
    }

    /**
     * Find all tricks that are favorited by the given user paginated.
     *
     * @param \App\User $user
     * @param int       $perPage
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator|\App\Trick[]
     */
    public function findAllFavorites(User $user, $perPage = self::PAGE_SIZE)
    {
        $tricks = $user->votes()->orderBy('created_at', 'DESC')->paginate($perPage);

        return $tricks;
    }

    /**
     * Find a trick by the given slug.
     *
     * @param string $slug
     *
     * @return \App\Trick
     */
    public function findBySlug($slug)
    {
        $trick = $this->model;

        if(Auth::user() && $this->isTrickOwnedByUser($slug, Auth::user()->id))
            $trick = $trick->withDrafted();

        return $trick->whereSlug($slug)->first();
    }

    /**
     * Find all the tricks paginated.
     *
     * @param int $perPage
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator|\App\Trick[]
     */
    public function findAllPaginated($perPage = self::PAGE_SIZE)
    {
        $tricks = $this->model->orderBy('created_at', 'DESC')->paginate($perPage);

        return $tricks;
    }

    /**
     * Find all tricks order by the creation date paginated.
     *
     * @param int $per_page
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator|\App\Trick[]
     */
    public function findMostRecent($per_page = self::PAGE_SIZE)
    {
        return $this->findAllPaginated($per_page);
    }

    /**
     * Find the tricks ordered by the number of comments paginated.
     *
     * @param int $per_page
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator|\App\Trick[]
     */
    public function findMostCommented($perPage = self::PAGE_SIZE)
    {
        $tricks = $this->model->orderBy('created_at', 'desc')->get();

        $tricks = Disqus::appendCommentCounts($tricks);

        $tricks = $tricks->sortBy(function ($trick) {
            return $trick->comment_count;
        })->reverse();

        $page = \Input::get('page', 1);
        $skip = ($page - 1) * $perPage;
        $items = $tricks->all();
        array_splice($items, 0, $skip);

        return new LengthAwarePaginator($items, count($tricks), $perPage);
    }

    /**
     * Find the tricks ordered by popularity (most liked / viewed) paginated.
     *
     * @param int $per_page
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator|\App\Trick[]
     */
    public function findMostPopular($per_page = self::PAGE_SIZE)
    {
        return $this->model
                    ->orderByRaw('(tricks.vote_cache * 5 + tricks.view_cache) DESC')
                    ->paginate($per_page);
    }

    /**
     * Find the last 15 tricks that were added.
     *
     * @return \Illuminate\Database\Eloquent\Collection|\App\Trick[]
     */
    public function findForFeed()
    {
        return $this->model->orderBy('created_at', 'desc')->limit(15)->get();
    }

    /**
     * Find all tricks.
     *
     * @return \Illuminate\Database\Eloquent\Collection|\App\Trick[]
     */
    public function findAllForSitemap()
    {
        return $this->model->orderBy('created_at', 'desc')->get();
    }

    /**
     * Find all tricks for the category that matches the given slug.
     *
     * @param string $slug
     * @param int    $perPage
     *
     * @return array
     */
    public function findByCategory($slug, $perPage = self::PAGE_SIZE)
    {
        $category = $this->category->whereSlug($slug)->first();

        if (is_null($category)) {
            throw new CategoryNotFoundException('The category "'.$slug.'" does not exist!');
        }

        $tricks = $category->tricks()->orderBy('created_at', 'DESC')->paginate($perPage);

        return [$category, $tricks];
    }

    /**
     * Find all tricks that match the given search term.
     *
     * @param string $term
     * @param int    $perPage
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator|\App\Trick[]
     */
    public function searchByTermPaginated($term, $perPage = self::PAGE_SIZE)
    {
        $tricks = $this->model
                        ->Where('title', 'LIKE', '%'.$term.'%')
                        ->orWhere('content', 'LIKE', '%'.$term.'%')
                        ->orWhereHas('tags', function ($query) use ($term) {
                            $query->where('title', 'LIKE', '%'.$term.'%')
                                  ->orWhere('slug', 'LIKE', '%'.$term.'%');
                        })
                        ->orWhereHas('categories', function ($query) use ($term) {
                            $query->where('name', 'LIKE', '%'.$term.'%')
                                  ->orWhere('slug', 'LIKE', '%'.$term.'%');
                        })
                        ->orderBy('created_at', 'desc')
                        ->orderBy('title', 'asc')
                        ->whereNull('deleted_at')
                        ->paginate($perPage);

        return $tricks;
    }

    /**
     * Get a list of tag ids that are associated with the given trick.
     *
     * @param \App\Trick $trick
     *
     * @return array
     */
    public function listTagsIdsForTrick(Trick $trick)
    {
        return $trick->tags->lists('id')->toArray();
    }

    /**
     * Get a list of category ids that are associated with the given trick.
     *
     * @param \App\Trick $trick
     *
     * @return array
     */
    public function listCategoriesIdsForTrick(Trick $trick)
    {
        return $trick->categories->lists('id')->toArray();
    }

    /**
     * Create a new trick in the database.
     *
     * @param array $data
     *
     * @return \App\Trick
     */
    public function create(array $data)
    {
        $trick = $this->getNew();

        $trick->user_id = $data['user_id'];
        $trick->title = $data['title'];
        $trick->content = $data['content'];
        $trick->is_draft= isset($data['is_draft']);

        $trick->save();

        $trick->tags()->sync($data['tags']);
        $trick->categories()->sync($data['categories']);

        return $trick;
    }

    /**
     * Update the trick in the database.
     *
     * @param \App\Trick $trick
     * @param array      $data
     *
     * @return \App\Trick
     */
    public function edit(Trick $trick, array $data)
    {
        //$trick->user_id = $data['user_id'];
        $trick->title = $data['title'];
        $trick->content = $data['content'];
        $trick->is_draft= isset($data['is_draft']);

        $trick->save();

        $trick->tags()->sync($data['tags']);
        $trick->categories()->sync($data['categories']);

        return $trick;
    }

    /**
     * Increment the view count on the given trick.
     *
     * @param \App\Trick $trick
     *
     * @return \App\Trick
     */
    public function incrementViews(Trick $trick)
    {
        $trick->view_cache = $trick->view_cache + 1;
        $trick->save();

        return $trick;
    }

    /**
     * Find all tricks for the tag that matches the given slug.
     *
     * @param string $slug
     * @param int    $perPage
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator|\App\Trick[]
     */
    public function findByTag($slug, $perPage = self::PAGE_SIZE)
    {
        $tag = $this->tag->whereSlug($slug)->first();

        if (is_null($tag)) {
            throw new TagNotFoundException('The tag "'.$slug.'" does not exist!');
        }

        $tricks = $tag->tricks()->orderBy('created_at', 'desc')->paginate($perPage);

        return [$tag, $tricks];
    }

    /**
     * Find the next trick that was added after the given trick.
     *
     * @param \App\Trick $trick
     *
     * @return \App\Trick|null
     */
    public function findNextTrick(Trick $trick)
    {
        $next = $this->model->where('created_at', '>=', $trick->created_at)
                            ->where('id', '<>', $trick->id)
                            ->orderBy('created_at', 'asc')
                            ->first(['slug', 'title']);

        return $next;
    }

    /**
     * Find the previous trick added before the given trick.
     *
     * @param \App\Trick $trick
     *
     * @return \App\Trick|null
     */
    public function findPreviousTrick(Trick $trick)
    {
        $prev = $this->model->where('created_at', '<=', $trick->created_at)
                            ->where('id', '<>', $trick->id)
                            ->orderBy('created_at', 'desc')
                            ->first(['slug', 'title']);

        return $prev;
    }

    /**
     * Check if the user owns the trick corresponding to the given slug.
     *
     * @param string $slug
     * @param mixed  $userId
     *
     * @return bool
     */
    public function isTrickOwnedByUser($slug, $userId)
    {
        return $this->model->withDrafted()->whereSlug($slug)->whereUserId($userId)->exists();
    }

    /**
     * Get the trick creation form service.
     *
     * @return \App\Services\Forms\TrickForm
     */
    public function getCreationForm()
    {
        return new TrickForm();
    }

    /**
     * Get the trick edit form service.
     *
     * @return \App\Services\Forms\TrickEditForm
     */
    public function getEditForm($id)
    {
        return new TrickEditForm($id);
    }

    /**
     * Delete the trick by id.
     *
     * @param $id
     * @return int
     */
    public function delete($id)
    {
        return $this->model->destroy($id);
    }
}
