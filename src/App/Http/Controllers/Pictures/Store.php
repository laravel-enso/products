<?php

namespace LaravelEnso\Products\App\Http\Controllers\Pictures;

use Illuminate\Routing\Controller;
use LaravelEnso\Products\App\Http\Requests\ValidatePictureRequest;
use LaravelEnso\Products\App\Models\Product;

class Store extends Controller
{
    public function __invoke(ValidatePictureRequest $request, Product $product)
    {
        $product->uploadPictures($request->allFiles());
    }
}
