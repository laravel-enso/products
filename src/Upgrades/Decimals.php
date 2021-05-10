<?php

namespace LaravelEnso\Products\Upgrades;

use Illuminate\Support\Facades\Schema;
use LaravelEnso\Upgrade\Contracts\MigratesTable;
use LaravelEnso\Upgrade\Contracts\ShouldRunManually;

class Decimals implements MigratesTable, ShouldRunManually
{
    public function isMigrated(): bool
    {
        return false;
    }

    public function migrateTable(): void
    {
        Schema::table('products', fn ($table) => $table
            ->unsignedDecimal('list_price', 13, 4)->change());

        Schema::table('product_supplier', fn ($table) => $table
            ->unsignedDecimal('acquisition_price', 13, 4)->change());
    }
}
