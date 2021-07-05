<?php

namespace LaravelEnso\Products\Imports\Importers;

use LaravelEnso\DataImport\Contracts\Importable;
use LaravelEnso\DataImport\Models\DataImport;
use LaravelEnso\Helpers\Services\Obj;
use LaravelEnso\Products\Imports\Product;

class State implements Importable
{
    public function run(Obj $row, DataImport $import)
    {
        Product::get($row)
            ->update(['is_active' => $row->get('active')]);
    }
}
