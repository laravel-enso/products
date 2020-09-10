<?php

use Faker\Generator as Faker;
use LaravelEnso\Categories\Models\Category;
use LaravelEnso\Companies\Models\Company;
use LaravelEnso\Helpers\Enums\VatRates;
use LaravelEnso\MeasurementUnits\Models\MeasurementUnit;
use LaravelEnso\PackagingUnits\Models\PackagingUnit;
use LaravelEnso\Products\Models\Product;

$factory->define(Product::class, fn (Faker $faker) => [
    'category_id' => fn () => factory(Category::class)->create()->id,
    'manufacturer_id' => fn () => factory(Company::class)->create()->id,
    'packaging_unit_id' => fn () => optional(PackagingUnit::first())->id
        ?? factory(PackagingUnit::class)->create()->id,
    'measurement_unit_id' => fn () => optional(MeasurementUnit::first())->id
        ?? factory(MeasurementUnit::class)->create()->id,
    'name' => $faker->word,
    'part_number' => 'P'.(Product::max('id') + 1),
    'internal_code' => 'CT-'.$faker->numberBetween(0, 500),
    'list_price' => $faker->numberBetween(1, 300),
    'vat_percent' => VatRates::keys()->random(),
    'package_quantity' => $faker->numberBetween(0, 5),
    'description' => $faker->text(50),
    'link' => $faker->url,
    'is_active' => true,
]);
