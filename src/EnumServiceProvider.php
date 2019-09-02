<?php

use LaravelEnso\Enums\EnumServiceProvider as ServiceProvider;
use LaravelEnso\Products\app\Enums\MeasurementUnits;

class EnumServiceProvider extends ServiceProvider
{
    protected $register = [
        'measurementUnits' => MeasurementUnits::class,
    ];
}