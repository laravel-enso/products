<?php

namespace LaravelEnso\Products\Forms\Builders;

use LaravelEnso\Forms\Services\Form;
use LaravelEnso\MeasurementUnits\Models\MeasurementUnit;
use LaravelEnso\PackagingUnits\Models\PackagingUnit;
use LaravelEnso\Products\Http\Resources\Supplier;
use LaravelEnso\Products\Models\Product;

class ProductForm
{
    protected const TemplatePath = __DIR__.'/../Templates/product.json';

    protected Form $form;

    public function __construct()
    {
        $this->form = new Form(static::TemplatePath);
    }

    public function create()
    {
        return $this->form
            ->value('measurement_unit_id', MeasurementUnit::first()->id)
            ->value('packaging_unit_id', PackagingUnit::first()->id)
            ->create();
    }

    public function edit(Product $product)
    {
        return $this->editForm($product)->edit($product);
    }

    protected function editForm(Product $product): Form
    {
        return $this->form
            ->show('gallery')
            ->value('suppliers', Supplier::collection($product->suppliers))
            ->value('defaultSupplierId', $product->defaultSupplier()?->id);
    }
}
