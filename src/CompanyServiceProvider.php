<?php

namespace LaravelEnso\Products;

use Illuminate\Support\ServiceProvider;
use LaravelEnso\Companies\App\Models\Company;
use LaravelEnso\DynamicMethods\App\Services\Methods;
use LaravelEnso\Products\App\Dynamics\Methods\Company\HasMappedProducts;
use LaravelEnso\Products\App\Dynamics\Relations\Company\Products;

class CompanyServiceProvider extends ServiceProvider
{
    private $methods = [
        Products::class,
        HasMappedProducts::class,
    ];

    public function boot()
    {
        Methods::bind(Company::class, $this->methods);
    }
}
