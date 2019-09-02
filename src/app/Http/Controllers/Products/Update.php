<?php

namespace LaravelEnso\Products\app\Http\Controllers\Products;

use Illuminate\Routing\Controller;
use LaravelEnso\Products\app\Models\Product;
use LaravelEnso\Products\app\Http\Requests\ValidateProductUpdate;

class Update extends Controller
{
    public function __invoke(ValidateProductUpdate $request, Product $product)
    {
        $product->inCents(false)->update($request->validated());

        $product->syncSuppliers(
            $request->get('suppliers'), $request->get('defaultSupplierId')
        );
        
        return ['message' => __('The product was successfully updated')];
    }
}
