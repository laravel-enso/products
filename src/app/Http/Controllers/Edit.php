<?php

namespace LaravelEnso\Products\App\Http\Controllers;

use Illuminate\Routing\Controller;
use LaravelEnso\Products\App\Forms\Builders\ProductForm;
use LaravelEnso\Products\App\Models\Product;

class Edit extends Controller
{
    public function __invoke(Product $product, ProductForm $form)
    {
        return ['form' => $form->edit($product)];
    }
}
