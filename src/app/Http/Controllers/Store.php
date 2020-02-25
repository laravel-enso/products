<?php

namespace LaravelEnso\Products\App\Http\Controllers;

use Illuminate\Routing\Controller;
use LaravelEnso\Products\App\Http\Requests\ValidateProductRequest;
use LaravelEnso\Products\App\Models\Product;

class Store extends Controller
{
    public function __invoke(ValidateProductRequest $request, Product $product)
    {
        $product
            //->inCents(false)
            ->fill($request->validated())->save();

        $product->syncSuppliers(
            $request->get('suppliers'),
            $request->get('defaultSupplierId')
        );

        return [
            'message' => __('The product was successfully created'),
            'redirect' => 'products.edit',
            'param' => ['product' => $product->id],
        ];
    }
}
