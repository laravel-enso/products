<?php

namespace LaravelEnso\Products\App\Services\Upgrades;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use LaravelEnso\Upgrade\App\Contracts\MigratesTable;

class Products implements MigratesTable
{
    public function isMigrated(): bool
    {
        return Schema::hasColumn('products', 'category_id');
    }

    public function migrateTable(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->unsignedInteger('category_id')->index()->nullable()
                ->after('measurement_unit_id');
            $table->foreign('category_id')->references('id')
                ->on('categories');
        });
    }
}
