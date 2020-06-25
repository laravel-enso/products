<?php

namespace LaravelEnso\Products;

use Illuminate\Support\ServiceProvider;
use LaravelEnso\Companies\Models\Company;
use LaravelEnso\DynamicMethods\Services\Methods;
use LaravelEnso\Products\Dynamics\Relations\Company\ManufacturedProducts;
use LaravelEnso\Products\Dynamics\Relations\Company\Products;

class CompanyServiceProvider extends ServiceProvider
{
    private $methods = [
        Products::class,
        ManufacturedProducts::class,
    ];

    public function boot()
    {
        Methods::bind(Company::class, $this->methods);
    }
}
