<?php

namespace LaravelEnso\Products\app\Http\Controllers\MeasurementUnits;

use Illuminate\Routing\Controller;
use LaravelEnso\Products\app\Models\MeasurementUnit;
use LaravelEnso\Products\app\Http\Requests\ValidateMeasurementUnitRequest;

class Store extends Controller
{
    public function __invoke(ValidateMeasurementUnitRequest $request, MeasurementUnit $measurementunit)
    {
        $measurementunit->fill($request->validated())->save();

        return [
            'message' => __('The measurementunit was successfully created'),
            'redirect' => 'administration.measurementUnits.edit',
            'param' => ['measurementunit' => $measurementunit->id],
        ];
    }
}
