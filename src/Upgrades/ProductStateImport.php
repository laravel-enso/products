<?php

namespace LaravelEnso\Products\Upgrades;

use LaravelEnso\DataImport\Models\DataImport;
use LaravelEnso\Upgrade\Contracts\MigratesData;

class ProductStateImport implements MigratesData
{
    public function isMigrated(): bool
    {
        return DataImport::whereType('activeProductsUpdate')
            ->doesntExist();
    }

    public function migrateData(): void
    {
        DataImport::whereType('activeProductsUpdate')
            ->update(['type' => 'productState']);
    }
}
