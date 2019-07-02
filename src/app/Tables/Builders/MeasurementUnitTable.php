<?php

namespace LaravelEnso\Products\app\Tables\Builders;

use LaravelEnso\Tables\app\Services\Table;
use LaravelEnso\Products\app\Models\MeasurementUnit;

class MeasurementUnitTable extends Table
{
    protected $templatePath = __DIR__.'/../Templates/measurementUnits.json';

    public function query()
    {
        return MeasurementUnit::selectRaw('
            measurement_units.id as "dtRowId"
        ');
    }
}
