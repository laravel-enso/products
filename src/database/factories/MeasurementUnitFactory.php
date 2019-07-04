<?php

use Faker\Generator as Faker;
use LaravelEnso\Products\app\Models\MeasurementUnit;

$factory->define(MeasurementUnit::class, function (Faker $faker) {
    return [
        'name' => $faker->word->unique(),
        'order_index' => MeasurementUnit::max('order_index') + 1,
        'is_active' => true,
    ];
});
