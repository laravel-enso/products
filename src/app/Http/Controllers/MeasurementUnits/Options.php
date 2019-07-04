<?php

namespace LaravelEnso\Products\app\Http\Controllers\MeasurementUnits;

use Illuminate\Routing\Controller;
use LaravelEnso\Select\app\Traits\OptionsBuilder;
use LaravelEnso\Products\app\Models\MeasurementUnit;

class Options extends Controller
{
    use OptionsBuilder;

    protected $model = MeasurementUnit::class;

    public function query()
    {
        return MeasurementUnit::active();
    }
}
