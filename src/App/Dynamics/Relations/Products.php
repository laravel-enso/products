<?php

namespace LaravelEnso\Products\App\Dynamics\Relations;

use Closure;
use LaravelEnso\DynamicMethods\App\Contracts\Method;
use LaravelEnso\Products\App\Models\Product;

class Products implements Method
{
    public function name(): string
    {
        return 'products';
    }

    public function closure(): Closure
    {
        return fn () => $this->belongsToMany(
            Product::class, 'product_supplier', 'supplier_id', 'product_id'
        )->withTimeStamps();
    }
}
