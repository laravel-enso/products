<?php

namespace LaravelEnso\Products\App\Http\Controllers\Pictures;

use Illuminate\Routing\Controller;
use LaravelEnso\Products\App\Http\Resources\Picture;
use LaravelEnso\Products\App\Models\Product;

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
