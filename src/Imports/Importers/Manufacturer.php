<?php

namespace LaravelEnso\Products\Imports\Importers;

use Illuminate\Support\Facades\App;
use LaravelEnso\Companies\Models\Company;
use LaravelEnso\DataImport\Contracts\Importable;
use LaravelEnso\DataImport\Models\DataImport;
use LaravelEnso\Helpers\Services\Obj;
use LaravelEnso\Products\Imports\Product;

class Manufacturer implements Importable
{
    public function run(Obj $row, DataImport $import)
    {
        $newManufacturer = Company::cacheGetBy('name', $row->get('new_manufacturer'));

        App::make(Product::class)::get($row)
            ->update(['manufacturer_id' => $newManufacturer->id]);
    }
}
