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

        if ($request->filled('suppliers')) {
            $product->syncSuppliers(
                $request->get('suppliers'),
                $request->get('defaultSupplierId')
            );
        } else {
            $product->suppliers()->sync([]);
        }

        return ['message' => __('The product was successfully updated')];
    }
}
