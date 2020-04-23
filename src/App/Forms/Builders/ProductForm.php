<?php

namespace LaravelEnso\Products\App\Forms\Builders;

use LaravelEnso\Forms\App\Services\Form;
use LaravelEnso\Products\App\Http\Resources\Supplier;
use LaravelEnso\Products\App\Models\Product;

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
        return $this->form->create();
    }

    public function edit(Product $product)
    {
        return $this->form
            ->show('gallery')
            ->value('suppliers', Supplier::collection($product->suppliers))
            ->value('defaultSupplierId', optional($product->defaultSupplier())->id)
            ->edit($product);
    }
}
