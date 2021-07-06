<?php

namespace LaravelEnso\Products\Upgrades;

use Illuminate\Support\Facades\Schema;
use LaravelEnso\Upgrade\Contracts\MigratesTable;
use LaravelEnso\Upgrade\Contracts\ShouldRunManually;
use LaravelEnso\Upgrade\Helpers\Column;

class RequiredCategoryMfr implements MigratesTable, ShouldRunManually
{
    public function isMigrated(): bool
    {
        return Column::isNotNullable('products', 'category_id')
            && Column::isNotNullable('products', 'manufacturer_id')
            && Column::isNotNullable('products', 'internal_code');
    }

    public function migrateTable(): void
    {
        Schema::table('products', function ($table) {
            $table->unsignedInteger('manufacturer_id')->nullable(false)->change();
            $table->unsignedInteger('category_id')->nullable(false)->change();
            $table->unsignedInteger('internal_code')->nullable(false)->change();
        });
    }
}
