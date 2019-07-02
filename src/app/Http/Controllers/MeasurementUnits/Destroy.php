<?php

namespace LaravelEnso\Products\app\Http\Controllers\MeasurementUnits;

use Illuminate\Routing\Controller;
use LaravelEnso\Products\app\Models\MeasurementUnit;

class Destroy extends Controller
{
    public function __invoke(MeasurementUnit $measurementunit)
    {
        $measurementunit->delete();

        return [
            'message' => __('The measurementunit was successfully deleted'),
            'redirect' => 'administration.measurementUnits.index',
        ];
    }
}
