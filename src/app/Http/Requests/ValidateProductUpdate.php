<?php

namespace LaravelEnso\Products\app\Http\Requests;

use LaravelEnso\Products\app\Http\Requests\ValidateProductStore;

class ValidateProductUpdate extends ValidateProductStore
{
    protected function productQuery() 
    {
        return parent::productQuery()
            ->where('id', '<>', $this->route('product')->id);
    }
}