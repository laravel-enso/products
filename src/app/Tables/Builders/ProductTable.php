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
            products.id as "dtRowId",
            products.name,
            products.part_number,
            products.list_price,
            products.vat_percent as "vat",
            products.package_quantity,
            products.is_active,
            companies.name as "manufacturer", 
            measurement_unit
        ')->join('companies', 'products.manufacturer_id', '=', 'companies.id');
    }
}
