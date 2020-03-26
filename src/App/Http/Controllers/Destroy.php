<?php

namespace LaravelEnso\Products\App\Http\Controllers;

use Illuminate\Routing\Controller;
use LaravelEnso\Products\App\Models\Product;

class Destroy extends Controller
{
    public function __invoke(Product $product)
    {
        $product->delete();

        return [
            'message' => __('The product was successfully deleted'),
            'redirect' => 'products.index',
        ];
    }
}
