<?php

namespace LaravelEnso\Products\app\Tables\Builders;

use Illuminate\Database\Eloquent\Builder;
use LaravelEnso\Products\app\Models\Product;
use LaravelEnso\Tables\app\Contracts\Table;

class ProductTable implements Table
{
    protected const TemplatePath = __DIR__.'/../Templates/products.json';

    public function query(): Builder
    {
        return Product::selectRaw('
            products.id, 
            products.name, 
            products.part_number, 
            products.list_price,
            products.vat_percent as "vat", 
            products.package_quantity, 
            products.is_active,
            products.created_at,
            companies.name as "manufacturer",
            measurement_units.name as measurementUnit
        ')->leftJoin('companies', 'products.manufacturer_id', '=', 'companies.id')
        ->leftJoin('measurement_units', 'measurement_units.id', '=', 'products.measurement_unit_id');
    }

    public function templatePath(): string
    {
        return static::TemplatePath;
    }
}
