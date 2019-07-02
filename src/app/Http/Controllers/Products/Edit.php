<?php

namespace LaravelEnso\Products\app\Http\Controllers\Products;

use Illuminate\Routing\Controller;
use LaravelEnso\Products\app\Models\Product;
use LaravelEnso\Products\app\Forms\Builders\ProductForm;

class Edit extends Controller
{
    public function __invoke(Product $product, ProductForm $form)
    {
        return ['form' => $form->edit($product)];
    }
}
