<?php

namespace LaravelEnso\Products\app\Http\Requests;

class ValidateProductUpdate extends ValidateProductStore
{
    protected function productQuery()
    {
        return parent::productQuery()
            ->where('id', '<>', $this->route('product')->id);
    }
}
