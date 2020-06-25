<?php

namespace LaravelEnso\Products\Http\Controllers;

use Illuminate\Routing\Controller;
use LaravelEnso\Products\Forms\Builders\ProductForm;
use LaravelEnso\Products\Models\Product;

class Edit extends Controller
{
    public function __invoke(Product $product, ProductForm $form)
    {
        return ['form' => $form->edit($product)];
    }
}
