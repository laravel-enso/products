<?php

namespace LaravelEnso\Products\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use LaravelEnso\Categories\Models\Category;
use LaravelEnso\Companies\Models\Company;
use LaravelEnso\Helpers\Enums\VatRates;
use LaravelEnso\MeasurementUnits\Models\MeasurementUnit;
use LaravelEnso\PackagingUnits\Models\PackagingUnit;
use LaravelEnso\Products\Models\Product;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        return [
            'category_id' => Category::factory(),
            'manufacturer_id' => Company::factory()->test(),
            'packaging_unit_id' => fn () => optional(PackagingUnit::first())->id
                ?? PackagingUnit::factory()->create()->id,
            'measurement_unit_id' => fn () => optional(MeasurementUnit::first())->id
                ?? MeasurementUnit::factory()->create()->id,
            'name' => $this->faker->word,
            'part_number' => 'P'.(Product::max('id') + 1),
            'internal_code' => 'CT-'.$this->faker->numberBetween(0, 500),
            'list_price' => $this->faker->numberBetween(1, 300),
            'vat_percent' => VatRates::keys()->random(),
            'package_quantity' => $this->faker->numberBetween(0, 5),
            'description' => $this->faker->text(50),
            'link' => $this->faker->url,
            'is_active' => true,
        ];
    }
}
