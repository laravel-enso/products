<?php

namespace LaravelEnso\Products\Imports\Validators;

use LaravelEnso\Categories\Models\Category as Model;
use LaravelEnso\DataImport\Models\DataImport;
use LaravelEnso\Helpers\Services\Obj;

class Category extends Product
{
    public function run(Obj $row, DataImport $import)
    {
        parent::run($row, $import);

        $category = Model::cacheGetBy('name', $row->get('category'));

        if (! $category) {
            $this->addError(__('Category not found'));
            return;
        }

        if ($category->isParent()) {
            $this->addError(__('Must choose a subcategory'));
        }
    }
}
