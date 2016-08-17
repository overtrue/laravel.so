<?php

namespace App\Databases;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ScopeInterface;

class DraftTrickScope implements ScopeInterface
{
    /**
     * All of the extensions to be added to the builder.
     *
     * @var array
     */
    protected $extensions = ['WithDrafted', 'OnlyDrafted'];

    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        $builder->where($model->getQualifiedIsDraftColumn(), 0);

        $this->extend($builder);
    }

    /**
     * Remove the scope from the given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function remove(Builder $builder, Model $model){
        $column = $model->getQualifiedIsDraftColumn();

        $query = $builder->getQuery();
        $query->setBindings([]);

        $query->wheres = collect($query->wheres)->reject(function ($where) use ($column) {
            return $this->isDraftConstraint($where, $column);
        })->values()->all();
    }

    /**
     * Extend the query builder with the needed functions.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @return void
     */
    public function extend(Builder $builder)
    {
        foreach ($this->extensions as $extension) {
            $this->{"add{$extension}"}($builder);
        }
    }

    /**
     * Add the with-drafted extension to the builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @return void
     */
    public function addWithDrafted(Builder $builder)
    {
        $builder->macro('withDrafted', function (Builder $builder) {
            $this->remove($builder, $builder->getModel());

            return $builder;
        });
    }

    /**
     * Add the only-drafted extension to the builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @return void
     */
    public function addOnlyDrafted(Builder $builder)
    {
        $builder->macro('onlyDrafted', function (Builder $builder) {
            $model = $builder->getModel();

            $this->remove($builder, $model);

            $builder->getQuery()->where($model->getQualifiedIsDraftName(), 1);

            return $builder;
        });
    }

    /**
     * Determine if the given where clause is a is draft constraint.
     *
     * @param  array   $where
     * @param  string  $column
     * @return bool
     */
    public function isDraftConstraint(array $where, $column)
    {
        return $where['type'] == 'Basic' && $where['column'] == $column;
    }
}
