<?php

namespace LaravelEnso\Products\Imports\Importers;

use LaravelEnso\Core\Models\User;
use LaravelEnso\DataImport\Contracts\Importable;
use LaravelEnso\Helpers\Services\Obj;
use LaravelEnso\Products\Models\Product;

class ActiveProductsUpdateImporter implements Importable
{
    public function run(Obj $row, User $user, Obj $params)
    {
        $product = Product::wherePartNumber($row->get('part_number'))->first();

        $product->update([
            'is_active' => $row->get('active'),
        ]);
    }
}
