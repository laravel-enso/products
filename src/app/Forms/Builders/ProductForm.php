<?php

namespace LaravelEnso\Products\app\Forms\Builders;

use LaravelEnso\Forms\app\Services\Form;
use LaravelEnso\Products\app\Models\Product;

class ProductForm
{
    private const TemplatePath = __DIR__.'/../Templates/product.json';

    private $form;

    public function __construct()
    {
        $this->form = new Form(self::TemplatePath);
    }

    public function create()
    {
        return $this->form->create();
    }

    public function edit(Product $product)
    {
        return $this->form->edit($product);
    }
}
