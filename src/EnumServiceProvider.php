<?php

namespace LaravelEnso\Products;

use LaravelEnso\Enums\EnumServiceProvider as ServiceProvider;
use LaravelEnso\Products\app\Enums\MeasurementUnits;

class EnumServiceProvider extends ServiceProvider
{
    public $register = [
        'measurementUnits' => MeasurementUnits::class,
    ];
}
