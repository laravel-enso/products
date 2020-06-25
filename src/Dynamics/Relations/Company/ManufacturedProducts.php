<?php

namespace LaravelEnso\Products\Dynamics\Relations\Company;

use Closure;
use LaravelEnso\DynamicMethods\Contracts\Method;
use LaravelEnso\Products\Models\Product;

class ManufacturedProducts implements Method
{
    public function name(): string
    {
        return 'manufacturedProducts';
    }

    public function closure(): Closure
    {
        return fn () => $this->hasMany(Product::class, 'manufacturer_id');
    }
}
