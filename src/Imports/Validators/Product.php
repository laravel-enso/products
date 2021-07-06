<?php

namespace LaravelEnso\Products\Imports\Validators;

use Illuminate\Support\Facades\App;
use LaravelEnso\DataImport\Models\DataImport;
use LaravelEnso\DataImport\Services\Validators\Validator;
use LaravelEnso\Helpers\Services\Obj;
use LaravelEnso\Products\Imports\Product as Resolver;

class Product extends Validator
{
    public function run(Obj $row, DataImport $import)
    {
        if (! App::make(Resolver::class)::get($row)) {
            $this->addError(__('Product not found'));
        }
    }
}
