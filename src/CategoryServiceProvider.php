<?php

namespace LaravelEnso\Products;

use Illuminate\Support\ServiceProvider;
use LaravelEnso\Categories\Models\Category;
use LaravelEnso\DynamicMethods\Services\Methods;
use LaravelEnso\Products\Dynamics\Relations\Category\Products;

class CategoryServiceProvider extends ServiceProvider
{
    private $methods = [
        Products::class,
    ];

    public function boot()
    {
        Methods::bind(Category::class, $this->methods);
    }
}
