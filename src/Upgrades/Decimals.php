<?php

namespace LaravelEnso\Products\Upgrades;

use Illuminate\Support\Facades\Schema;
use LaravelEnso\Upgrade\Contracts\MigratesTable;

class Decimals implements MigratesTable
{
    public function isMigrated(): bool
    {
        return false;
    }

    public function migrateTable(): void
    {
        Schema::table('products', fn ($table) => $table
            ->unsignedDecimal('list_price', 13, 4)->change());
    }
}
