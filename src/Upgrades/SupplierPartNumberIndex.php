<?php

namespace LaravelEnso\Products\Upgrades;

use Illuminate\Support\Facades\Schema;
use LaravelEnso\Upgrade\Contracts\MigratesTable;
use LaravelEnso\Upgrade\Helpers\Table;

class SupplierPartNumberIndex implements MigratesTable
{
    public function isMigrated(): bool
    {
        return Table::hasIndex('product_supplier', 'product_supplier_part_number_index');
    }

    public function migrateTable(): void
    {
        Schema::table('product_supplier', fn ($table) => $table->index(['part_number']));
    }
}
