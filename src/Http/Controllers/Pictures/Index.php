<?php

namespace LaravelEnso\Products\Http\Controllers\Pictures;

use Illuminate\Routing\Controller;
use LaravelEnso\Products\Http\Resources\Picture;
use LaravelEnso\Products\Models\Product;

class Index extends Controller
{
    public function __invoke(Product $product)
    {
        return Picture::collection(
            $product->pictures()
                ->with('file')
                ->get()
        );
    }
}
