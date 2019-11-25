<?php

use Faker\Generator as Faker;
use LaravelEnso\Companies\app\Models\Company;
use LaravelEnso\MeasurementUnits\app\Models\MeasurementUnit;
use LaravelEnso\Products\app\Models\Product;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'manufacturer_id' => function () {
            return factory(Company::class)->create()->id;
        },
        'measurement_unit_id' => function () {
            return (factory(MeasurementUnit::class)->create())->id;
        },
        'name' => $faker->word,
        'part_number' => Product::max('part_number') + 1,
        'internal_code' => 'CT-'.$faker->numberBetween(0, 500),
        'list_price' => $faker->numberBetween(1, 300),
        'vat_percent' => collect([5, 19, 24])->random(),
        'package_quantity' => $faker->numberBetween(0, 5),
        'description' => $faker->text(50),
        'link' => $faker->url,
        'is_active' => true,
    ];
});
