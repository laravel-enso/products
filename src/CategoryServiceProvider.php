<?php

namespace LaravelEnso\Products;

use Illuminate\Support\ServiceProvider;
use LaravelEnso\Categories\App\Models\Category;
use LaravelEnso\DynamicMethods\App\Services\Methods;
use LaravelEnso\Products\App\Dynamics\Relations\Category\Products;

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
