<?php

namespace LaravelEnso\Products\Imports\Validators;

use LaravelEnso\DataImport\Models\DataImport;
use LaravelEnso\DataImport\Services\Validators\Validator;
use LaravelEnso\Helpers\Services\Obj;
use LaravelEnso\Products\Imports\Product;

class State extends Validator
{

    public function run(Obj $row, DataImport $import)
    {
        if (! Product::get($row)) {
            $this->addError(__('Product not found'));
        }
    }
}
