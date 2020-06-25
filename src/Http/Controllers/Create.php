<?php

namespace LaravelEnso\Products\Http\Controllers;

use Illuminate\Routing\Controller;
use LaravelEnso\Products\Forms\Builders\ProductForm;

class Create extends Controller
{
    public function __invoke(ProductForm $form)
    {
        return ['form' => $form->create()];
    }
}
