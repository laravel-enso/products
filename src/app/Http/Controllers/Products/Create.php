<?php

namespace LaravelEnso\Products\app\Http\Controllers\Products;

use Illuminate\Routing\Controller;
use LaravelEnso\Products\app\Forms\Builders\ProductForm;

class Create extends Controller
{
    public function __invoke(ProductForm $form)
    {
        return ['form' => $form->create()];
    }
}
