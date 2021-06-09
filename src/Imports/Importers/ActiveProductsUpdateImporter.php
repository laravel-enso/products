<?php

namespace LaravelEnso\Products\Imports\Importers;

use LaravelEnso\DataImport\Contracts\Importable;
use LaravelEnso\DataImport\Models\DataImport;
use LaravelEnso\Helpers\Services\Obj;
use LaravelEnso\Products\Models\Product;

class ActiveProductsUpdateImporter implements Importable
{
    public function run(Obj $row, DataImport $import)
    {
        Product::wherePartNumber($row->get('part_number'))
            ->first()
            ->update(['is_active' => $row->get('active')]);
    }
}
