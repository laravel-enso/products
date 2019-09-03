<?php

namespace LaravelEnso\Products;

use App\Models\Product;
use Illuminate\Support\ServiceProvider;
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
            );
        });

        Company::addDynamicMethod('hasMappedProducts', function () {
            return $this->products()->exists();
        });
    }
}
