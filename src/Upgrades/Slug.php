<?php

namespace LaravelEnso\Products\Upgrades;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use LaravelEnso\Products\Models\Product;
use LaravelEnso\Upgrade\Contracts\MigratesData;
use LaravelEnso\Upgrade\Contracts\MigratesPostDataMigration;
use LaravelEnso\Upgrade\Contracts\MigratesTable;
use LaravelEnso\Upgrade\Contracts\ShouldRunManually;
use LaravelEnso\Upgrade\Helpers\Table;

class Slug implements MigratesTable, MigratesData, MigratesPostDataMigration, ShouldRunManually
{
    public function isMigrated(): bool
    {
        return Table::hasColumn('products', 'slug');
    }

    public function migrateTable(): void
    {
        Schema::table('products', fn ($table) => $table
            ->string('slug')->nullable()->after('name')->index());

        if (! Table::hasIndex('products', 'products_name_index')) {
            Schema::table('products', fn ($table) => $table->index(['name']));
        }
    }

    public function migrateData(): void
    {
        Product::query()->each(fn ($product) => $product
            ->update(['slug' => Str::slug($product->name)]));
    }

    public function migratePostDataMigration(): void
    {
        Schema::table('products', fn ($table) => $table
            ->string('slug')->nullable(false)->change());
    }
}
