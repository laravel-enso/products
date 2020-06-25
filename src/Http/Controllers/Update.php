<?php

namespace LaravelEnso\Products\Http\Controllers;

use Illuminate\Routing\Controller;
use LaravelEnso\Products\Http\Requests\ValidateProductRequest;
use LaravelEnso\Products\Models\Product;

class Update extends Controller
{
    public function __invoke(ValidateProductRequest $request, Product $product)
    {
        $product->update($request->validatedExcept('suppliers', 'defaultSupplierId'));

        $product->syncSuppliers(
            $request->get('suppliers'),
            $request->get('defaultSupplierId')
        );

        return ['message' => __('The product was successfully updated')];
    }
}
