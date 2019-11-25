<?php

namespace LaravelEnso\Products\app\Console\Commands\DatabaseUpgrades;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;
use LaravelEnso\Core\app\Commands\DatabaseUpgrades\DatabaseUpgrade;
use LaravelEnso\MeasurementUnits\app\Models\MeasurementUnit;

class ProductsUpgrade extends DatabaseUpgrade
{
    private $enum;

    public function __construct(string $enum = null)
    {
        parent::__construct();
        $this->enum = $enum;
    }

    protected function isMigrated()
    {
        return ! Schema::hasTable('products')
            || Schema::hasColumn('products', 'measurement_unit_id');
    }

    protected function migrateTable()
    {
        Artisan::call('vendor:publish', [
            '--tag' => 'measurement-units-factories',
            '--force' => true,
        ]);

        Artisan::call('vendor:publish', [
            '--tag' => 'measurement-units-seeders',
            '--force' => true,
        ]);

        if (! MeasurementUnit::exists()) {
            $this->seedEnums();
        }

        Schema::table('products', function (Blueprint $table) {
            $table->renameColumn('measurement_unit', 'measurement_unit_id');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->unsignedInteger('measurement_unit_id')->change();
            $table->foreign('measurement_unit_id')->references('id')
                ->on('measurement_units');
        });
    }

    protected function seedEnums(): void
    {
        if (! $this->enum) {
            Artisan::call('db:seed', [
                '--class' => 'MeasurementUnitsSeeder',
                '--force' => true,
            ]);

            return;
        }

        $this->enum::collection()->each(function ($name, $id) {
            factory(MeasurementUnit::class)->create([
                'id' => $id,
                'name' => $name,
                'description' => '',
            ]);
        });
    }
}
