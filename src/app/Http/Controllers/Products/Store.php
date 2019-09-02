<?php

namespace LaravelEnso\Products\app\Http\Controllers\Products;

use Illuminate\Routing\Controller;
use LaravelEnso\Products\app\Models\Product;
use LaravelEnso\Products\app\Http\Requests\ValidateProductStore;

class Store extends Controller
{
    public function __invoke(ValidateProductStore $request, Product $product)
    {
        $product->inCents(false)
            ->fill($request->validated())->save();

        $product->syncSuppliers(
            $request->get('suppliers'), $request->get('defaultSupplierId')
        );

        return [
            'message' => __('The product was successfully created'),
            'redirect' => 'products.edit',
            'param' => ['product' => $product->id],
        ];
    }
}
