<?php

namespace App\Repositories\Eloquent;

use Pinyin;
use App\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Services\Forms\CategoryForm;
use App\Repositories\CategoryRepositoryInterface;

class CategoryRepository extends AbstractRepository implements CategoryRepositoryInterface
{
    /**
     * Create a new DbCategoryRepository instance.
     *
     * @param \App\Category $category
     */
    public function __construct(Category $category)
    {
        $this->model = $category;
    }

    /**
     * Get an array of key-value pairs of all categories.
     *
     * @return array
     */
    public function listAll()
    {
        $categories = $this->model->lists('name', 'id');

        return $categories;
    }

    /**
     * Find all categories.
     *
     * @param string $orderColumn
     * @param string $orderDir
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Category[]
     */
    public function findAll($orderColumn = 'created_at', $orderDir = 'desc')
    {
        $categories = $this->model
                           ->orderBy($orderColumn, $orderDir)
                           ->get();

        return $categories;
    }

    /**
     * Find all categories with the associated number of tricks.
     *
     * @return \Illuminate\Database\Eloquent\Collection|\App\Trick[]
     */
    public function findAllWithTrickCount()
    {
        return $this->model->leftJoin('category_trick', 'categories.id', '=', 'category_trick.category_id')
                           ->leftJoin('tricks', 'tricks.id', '=', 'category_trick.trick_id')
                           ->where('tricks.is_draft', 0)
                           ->groupBy('categories.slug')
                           ->orderBy('trick_count', 'desc')
                           ->get([
                               'categories.name',
                               'categories.slug',
                               DB::raw('COUNT(tricks.id) as trick_count'),
                           ]);
    }

    /**
     * Find a category by id.
     *
     * @param mixed $id
     *
     * @return \App\Category
     */
    public function findById($id)
    {
        return $this->model->find($id);
    }

    /**
     * Create a new category in the database.
     *
     * @param array $data
     *
     * @return \App\Category
     */
    public function create(array $data)
    {
        $category = $this->getNew();

        $category->name = e($data['name']);
        $category->slug = e($data['name']);
        $category->description = $data['description'];
        $category->order = $this->getMaxOrder() + 1;

        $category->save();

        return $category;
    }

    /**
     * Update the specified category in the database.
     *
     * @param mixed $id
     * @param array $data
     *
     * @return \App\Category
     */
    public function update($id, array $data)
    {
        $category = $this->findById($id);

        $category->name = e($data['name']);
        $category->slug = e($data['name']);
        $category->description = $data['description'];

        $category->save();

        return $category;
    }

    /**
     * The the highest order number from the database.
     *
     * @return int
     */
    public function getMaxOrder()
    {
        return $this->model->max('order');
    }

    /**
     * Delete the specified category from the database.
     *
     * @param mixed $id
     */
    public function delete($id)
    {
        $category = $this->findById($id);
        $category->tricks()->detach();
        $category->delete();
    }

    /**
     * Re-arrange the categories in the database.
     *
     * @param array $data
     */
    public function arrange(array $data)
    {
        $ids = array_values($data);
        $categories = $this->model->whereIn('id', $ids)->get(['id']);

        foreach ($data as $order => $id) {
            if ($category = $categories->find($id)) {
                $category->order = $order;
                $category->save();
            }
        }
    }

    /**
     * Get the category create/update form service.
     *
     * @return \App\Services\Forms\CategoryForm
     */
    public function getForm()
    {
        return new CategoryForm();
    }
}
