<?php

namespace LaravelEnso\Products\Dynamics\Relations\Category;

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
        return fn () => $this->hasMany(Product::class);
    }
}
