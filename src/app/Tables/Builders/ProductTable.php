<?php

namespace LaravelEnso\Products\app\Tables\Builders;

use LaravelEnso\Tables\app\Services\Table;
use LaravelEnso\Products\app\Models\Product;

class ProductTable extends Table
{
    protected $templatePath = __DIR__.'/../Templates/products.json';

    public function query()
    {
        return Product::selectRaw('
            products.id as "dtRowId"
        ');
    }
}
