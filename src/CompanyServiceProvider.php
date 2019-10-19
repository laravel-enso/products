<?php

namespace LaravelEnso\Products;

use Illuminate\Support\ServiceProvider;
use LaravelEnso\Products\app\Models\Product;
use LaravelEnso\Companies\app\Models\Company;

class CompanyServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Company::addDynamicMethod('products', function () {
            return $this->belongsToMany(
                Product::class,
                'product_supplier',
                'supplier_id',
                'product_id'
            )->withTimeStamps();
        });

        Company::addDynamicMethod('hasMappedProducts', function () {
            return $this->products()->exists();
        });
    }
}
