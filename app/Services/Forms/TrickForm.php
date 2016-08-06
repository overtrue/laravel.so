<?php

namespace App\Services\Forms;

class TrickForm extends AbstractForm
{
    /**
     * The validation rules to validate the input data against.
     *
     * @var array
     */
    protected $rules = [
        'title' => 'required|min:4|unique:tricks,title',
        'tags' => 'required|min:1',
        'categories' => 'required|min:1',
        'content' => 'required|min:20',
    ];

    /**
     * Get the prepared input data.
     *
     * @return array
     */
    public function getInputData()
    {
        return array_only($this->inputData, [
            'title', 'content', 'tags', 'categories', 'is_draft',
        ]);
    }
}
