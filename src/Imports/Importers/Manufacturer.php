<?php

namespace LaravelEnso\Products\Imports\Importers;

use LaravelEnso\Companies\Models\Company;
use LaravelEnso\DataImport\Contracts\Importable;
use LaravelEnso\DataImport\Models\DataImport;
use LaravelEnso\Helpers\Services\Obj;
use LaravelEnso\Products\Models\Product;

class Manufacturer implements Importable
{
    public function run(Obj $row, DataImport $import)
    {
        $manufacturer = Company::cacheGetBy('name', $row->get('manufacturer'));

        Product::whereId($row->get('id'))
            ->update(['manufacturer_id' => $manufacturer->id]);
    }
}
