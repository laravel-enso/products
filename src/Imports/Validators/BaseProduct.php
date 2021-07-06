<?php

namespace LaravelEnso\Products\Imports\Validators;

use Illuminate\Support\Facades\App;
use LaravelEnso\Categories\Models\Category as Model;
use LaravelEnso\DataImport\Models\DataImport;
use LaravelEnso\DataImport\Services\Validators\Validator;
use LaravelEnso\Helpers\Services\Obj;
use LaravelEnso\Products\Imports\Product;

class BaseProduct extends Validator
{
    public function run(Obj $row, DataImport $import)
    {
        if (! App::make(Product::class)::get($row)) {
            $this->addError(__('Product not found'));
        }
    }
}
