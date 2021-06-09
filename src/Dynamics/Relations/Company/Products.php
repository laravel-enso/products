<?php

namespace LaravelEnso\Products\Dynamics\Relations\Company;

use Closure;
use LaravelEnso\DynamicMethods\Contracts\Method;
use LaravelEnso\Products\Models\Product;

class Products implements Method
{
    public function name(): string
    {
        return 'products';
    }

    public function closure(): Closure
    {
        //TODO check if we need the extra details
        return fn () => $this->belongsToMany(
            Product::class,
            'product_supplier',
            'supplier_id',
            'product_id'
        )->withTimeStamps();
    }
}
