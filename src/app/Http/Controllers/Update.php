<?php

namespace LaravelEnso\Products\App\Http\Controllers;

use Illuminate\Routing\Controller;
use LaravelEnso\Products\App\Http\Requests\ValidateProductRequest;
use LaravelEnso\Products\App\Models\Product;

class Update extends Controller
{
    public function __invoke(ValidateProductRequest $request, Product $product)
    {
        $product->inCents(false)->update($request->validated());

        $product->syncSuppliers(
            $request->get('suppliers'),
            $request->get('defaultSupplierId')
        );

        return ['message' => __('The product was successfully updated')];
    }
}
