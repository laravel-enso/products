<?php

namespace LaravelEnso\Products\App\Http\Controllers\Pictures;

use LaravelEnso\Products\App\Models\Product;
use Illuminate\Routing\Controller;
use LaravelEnso\Products\App\Http\Resources\Picture;

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
