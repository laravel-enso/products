<?php

namespace LaravelEnso\Products\Upgrades;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;
use LaravelEnso\PackagingUnits\Models\PackagingUnit;
use LaravelEnso\Products\Models\Product;
use LaravelEnso\Upgrade\Contracts\Applicable;
use LaravelEnso\Upgrade\Contracts\MigratesPostDataMigration;
use LaravelEnso\Upgrade\Contracts\MigratesTable;
use LaravelEnso\Upgrade\Contracts\ShouldRunManually;
use LaravelEnso\Upgrade\Helpers\Table;

class PackagingUnitId implements MigratesTable, Applicable, ShouldRunManually, MigratesPostDataMigration
{
    public function isMigrated(): bool
    {
        return Table::hasColumn('products', 'packaging_unit_id');
    }

    public function migrateTable(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->unsignedInteger('packaging_unit_id')->after('manufacturer_id')
                ->default(PackagingUnit::first()->id)
                ->index();

            $table->foreign('packaging_unit_id')->references('id')
                ->on('packaging_units');
        });
    }

    public function applicable(): bool
    {
        return Schema::hasTable('products')
            && Schema::hasColumn('products', 'package_quantity');
    }

    public function migratePostDataMigration(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->unsignedInteger('packaging_unit_id')
                ->default(null)
                ->change();
        });
    }
}
