<?php

namespace App\Databases;

trait DraftTrick
{
    /**
     * Boot the drafted trick trait for a model.
     *
     * @return void
     */
    public static function bootDraftTrick()
    {
        static::addGlobalScope(new DraftTrickScope);
    }

    /**
     * Determine if the model instance has been is-draft.
     *
     * @return bool
     */
    public function drafted()
    {
      return ! $this->{$this->getIsDraftColumn()};
    }

    /**
     * Get a new query builder that includes draft tricks.
     *
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public function withDrafted()
    {
        return (new static)->newQueryWithoutScope(new DraftTrickScope);
    }

    /**
     * Get a new query builder that only includes draft tricks.
     *
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public function onlyDrafted()
    {
        $instance = new static;

        $column = $instance->getQualifiedIsDraftColumn();

        return $instance->newQueryWithoutScope(new DraftTrickScope)->where($column, 1);
    }

    /**
     * Get the name of the "is draft" column.
     *
     * @return string
     */
    public function getIsDraftColumn()
    {
        return defined('static::IS_DRAFT') ? static::IS_DRAFT : 'is_draft';
    }

    /**
     * Get the fully qualified "is draft" column.
     *
     * @return string
     */
    public function getQualifiedIsDraftColumn()
    {
        return $this->getTable().'.'.$this->getIsDraftColumn();
    }
}
