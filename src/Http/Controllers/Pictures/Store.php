<?php

namespace LaravelEnso\Products\Http\Controllers\Pictures;

use Illuminate\Routing\Controller;
use LaravelEnso\Products\Http\Requests\ValidatePictureRequest;
use LaravelEnso\Products\Models\Product;

class Store extends Controller
{
    public function __invoke(ValidatePictureRequest $request, Product $product)
    {
        $product->uploadPictures($request->allFiles());
    }
}
