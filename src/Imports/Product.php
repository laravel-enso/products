<?php

namespace LaravelEnso\Products\Imports;

use LaravelEnso\Companies\Models\Company;
use LaravelEnso\Helpers\Services\Obj;
use LaravelEnso\Products\Models\Product as Model;

class Product
{
    public static function get(Obj $row): ?Model
    {
        $manufacturer = Company::cacheGetBy('name', $row->get('manufacturer'));

        return self::product($row, $manufacturer);
    }

    protected static function product(Obj $row, ?Company $manufacturer)
    {
        return Model::wherePartNumber($row->get('part_number'))
            ->whereManufacturerId($manufacturer?->id)
            ->first();
    }
}
