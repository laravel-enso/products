<?php

namespace LaravelEnso\Products\app\Http\Controllers\MeasurementUnits;

use Illuminate\Routing\Controller;
use LaravelEnso\Products\app\Forms\Builders\MeasurementUnitForm;

class Create extends Controller
{
    public function __invoke(MeasurementUnitForm $form)
    {
        return ['form' => $form->create()];
    }
}
