<?php

namespace LaravelEnso\Products\Imports\Validators;

use LaravelEnso\Categories\Models\Category as Model;
use LaravelEnso\DataImport\Models\DataImport;
use LaravelEnso\DataImport\Services\Validators\Validator;
use LaravelEnso\Helpers\Services\Obj;

class Category extends Validator
{
    public function run(Obj $row, DataImport $import)
    {
        $category = Model::cacheGetBy('name', $row->get('category'));

        if (! $category) {
            $this->addError(__('Category not found'));
        }
    }
}
