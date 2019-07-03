<?php

namespace LaravelEnso\Products\app\Http\Controllers\MeasurementUnits;

use Illuminate\Routing\Controller;
use LaravelEnso\Products\app\Models\MeasurementUnit;
use LaravelEnso\Products\app\Http\Requests\ValidateMeasurementUnitRequest;

class Update extends Controller
{
    public function __invoke(ValidateMeasurementUnitRequest $request, MeasurementUnit $measurementUnit)
    {
        $measurementUnit->update($request->validated());

        return ['message' => __('The measurement unit was successfully updated')];
    }
}
