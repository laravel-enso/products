<?php

namespace LaravelEnso\Products\Http\Controllers;

use Illuminate\Routing\Controller;
use LaravelEnso\Products\Http\Requests\ValidateProductRequest;
use LaravelEnso\Products\Models\Product;

class Store extends Controller
{
    public function __invoke(ValidateProductRequest $request, Product $product)
    {
        $product->fill($request->validatedExcept('suppliers', 'defaultSupplierId'))
            ->save();

        if (! empty($request->get('suppliers'))) {
            $product->syncSuppliers(
                $request->get('suppliers'),
                $request->get('defaultSupplierId')
            );
        }

        return [
            'message' => __('The product was successfully created'),
            'redirect' => 'products.edit',
            'param' => ['product' => $product->id],
        ];
    }
}
