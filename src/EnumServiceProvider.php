<?php

namespace LaravelEnso\Products;

use LaravelEnso\Products\app\Enums\MeasurementUnits;
use LaravelEnso\Enums\EnumServiceProvider as ServiceProvider;

class EnumServiceProvider extends ServiceProvider
{
    public $register = [
        'measurementUnits' => MeasurementUnits::class,
    ];
}
