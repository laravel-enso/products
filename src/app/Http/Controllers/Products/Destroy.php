<?php

namespace LaravelEnso\Products\app\Http\Controllers\Products;

use Illuminate\Routing\Controller;
use LaravelEnso\Products\app\Models\Product;

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
