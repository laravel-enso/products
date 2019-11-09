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
            products.measurement_unit,
            companies.name as "manufacturer"
        ')->leftJoin('companies', 'products.manufacturer_id', '=', 'companies.id');
    }

    public function templatePath(): string
    {
        return static::TemplatePath;
    }
}
