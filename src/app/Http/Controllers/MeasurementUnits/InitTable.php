<?php

namespace LaravelEnso\Products\app\Http\Controllers\MeasurementUnits;

use Illuminate\Routing\Controller;
use LaravelEnso\Tables\app\Traits\Init;
use LaravelEnso\Products\app\Tables\Builders\MeasurementUnitTable;

class InitTable extends Controller
{
    use Init;

    protected $tableClass = MeasurementUnitTable::class;
}
