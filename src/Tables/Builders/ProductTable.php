<?php

namespace LaravelEnso\Products\Tables\Builders;

use Illuminate\Database\Eloquent\Builder;
use LaravelEnso\Products\Models\Product;
use LaravelEnso\Tables\Contracts\Table;

class ProductTable implements Table
{
    protected const TemplatePath = __DIR__.'/../Templates/products.json';

    public function query(): Builder
    {
        return Product::with(['picture.file'])
            ->selectRaw('
            products.id, products.name, products.internal_code, products.part_number,
            products.list_price, products.vat_percent as "vat", products.package_quantity,
            products.is_active, products.created_at, companies.name as "manufacturer",
            measurement_units.name as measurementUnit, categories.name as category,
            packaging_units.name as packagingUnit
        ')->leftJoin('categories', 'products.category_id', 'categories.id')
            ->leftJoin('companies', 'products.manufacturer_id', 'companies.id')
            ->leftJoin('measurement_units', 'measurement_units.id', 'products.measurement_unit_id')
            ->leftJoin('packaging_units', 'packaging_units.id', 'products.packaging_unit_id');
    }

    public function templatePath(): string
    {
        return static::TemplatePath;
    }
}
