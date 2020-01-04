<?php

namespace LaravelEnso\Products;

use Illuminate\Support\ServiceProvider;
use LaravelEnso\Companies\App\Models\Company;
use LaravelEnso\Products\App\Models\Product;

class CompanyServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Company::addDynamicMethod('products', fn () => $this->belongsToMany(
            Product::class, 'product_supplier', 'supplier_id', 'product_id'
        )->withTimeStamps());

        Company::addDynamicMethod('hasMappedProducts', fn () => $this->products()->exists());
    }
}
