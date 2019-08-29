<?php

namespace LaravelEnso\Products\app\Forms\Builders;

use LaravelEnso\Forms\app\Services\Form;
use LaravelEnso\Products\app\Models\Product;

class ProductForm
{
    protected const TemplatePath = __DIR__.'/../Templates/product.json';

    protected $form;

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
        return $this->form->edit($product->inCents(false));
    }
}
