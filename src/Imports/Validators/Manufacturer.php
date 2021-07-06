<?php

namespace LaravelEnso\Products\Imports\Validators;

use LaravelEnso\Companies\Models\Company;
use LaravelEnso\DataImport\Models\DataImport;
use LaravelEnso\DataImport\Services\Validators\Validator;
use LaravelEnso\Helpers\Services\Obj;

class Manufacturer extends Validator
{
    public function run(Obj $row, DataImport $import)
    {
        $manufacturer = Company::cacheGetBy('name', $row->get('manufacturer'));

        if (! $manufacturer) {
            $this->addError(__('Manufacturer not found'));
        }
    }
}
