<?php

namespace LaravelEnso\Products\Upgrades;

use Illuminate\Support\Facades\Schema;
use LaravelEnso\Upgrade\Contracts\MigratesTable;
use LaravelEnso\Upgrade\Contracts\ShouldRunManually;
use LaravelEnso\Upgrade\Helpers\Column;

class PackageQuantity implements MigratesTable, ShouldRunManually
{
    public function isMigrated(): bool
    {
        return Column::isUnsigned('products', 'package_quantity');
    }

    public function migrateTable(): void
    {
        Schema::table('products', fn ($table) => $table
            ->unsignedInteger('package_quantity')->change());
    }
}
