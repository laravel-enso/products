<?php

namespace LaravelEnso\Products\Imports\Validators;

use LaravelEnso\Companies\Models\Company;
use LaravelEnso\DataImport\Models\DataImport;
use LaravelEnso\Helpers\Services\Obj;

class Manufacturer extends BaseProduct
{
    public function run(Obj $row, DataImport $import)
    {
        parent::run($row, $import);

        $manufacturer = Company::cacheGetBy('name', $row->get('new_manufacturer'));

        if (! $manufacturer) {
            $this->addError(__('New manufacturer not found'));
        }
    }
}
