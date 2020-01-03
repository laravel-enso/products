<?php

namespace LaravelEnso\Products;

use Illuminate\Support\ServiceProvider;
use LaravelEnso\Companies\app\Models\Company;
use LaravelEnso\Products\app\Models\Product;

class CompanyServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Company::addDynamicMethod('products', fn() => (
            $this->belongsToMany(
                Product::class,
                'product_supplier',
                'supplier_id',
                'product_id'
            )->withTimeStamps()
        ));

        Company::addDynamicMethod('hasMappedProducts', fn() => $this->products()->exists());
    }
}
