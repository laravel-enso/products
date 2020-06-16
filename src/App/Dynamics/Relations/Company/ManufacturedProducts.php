<?php

namespace LaravelEnso\Products\App\Dynamics\Relations\Company;

use Closure;
use LaravelEnso\DynamicMethods\App\Contracts\Method;
use LaravelEnso\Products\App\Models\Product;

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
