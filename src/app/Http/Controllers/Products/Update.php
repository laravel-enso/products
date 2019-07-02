<?php

namespace LaravelEnso\Products\app\Http\Controllers\Products;

use Illuminate\Routing\Controller;
use LaravelEnso\Products\app\Models\Product;
use LaravelEnso\Products\app\Http\Requests\ValidateProductRequest;

class Update extends Controller
{
    public function __invoke(ValidateProductRequest $request, Product $product)
    {
        $product->update($request->validated());

        return ['message' => __('The product was successfully updated')];
    }
}
