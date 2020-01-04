<?php

use LaravelEnso\Migrator\App\Database\Migration;
use LaravelEnso\Permissions\App\Enums\Types;

class CreateStructureForProducts extends Migration
{
    protected $permissions = [
        ['name' => 'products.index', 'description' => 'Show index for products', 'type' => Types::Read, 'is_default' => false],
        ['name' => 'products.create', 'description' => 'Create product', 'type' => Types::Write, 'is_default' => false],
        ['name' => 'products.store', 'description' => 'Store a new product', 'type' => Types::Write, 'is_default' => false],
        ['name' => 'products.edit', 'description' => 'Edit product', 'type' => Types::Write, 'is_default' => false],
        ['name' => 'products.update', 'description' => 'Update product', 'type' => Types::Write, 'is_default' => false],
        ['name' => 'products.destroy', 'description' => 'Delete product', 'type' => Types::Write, 'is_default' => false],
        ['name' => 'products.initTable', 'description' => 'Init table for product', 'type' => Types::Read, 'is_default' => false],
        ['name' => 'products.tableData', 'description' => 'Get table data for product', 'type' => Types::Read, 'is_default' => false],
        ['name' => 'products.exportExcel', 'description' => 'Export excel for product', 'type' => Types::Read, 'is_default' => false],
        ['name' => 'products.options', 'description' => 'Get product options for select', 'type' => Types::Read, 'is_default' => false],
        ['name' => 'products.suppliers', 'description' => 'Get product supplier options for select', 'type' => Types::Read, 'is_default' => false],
    ];

    protected $menu = [
        'name' => 'Products', 'icon' => 'fab product-hunt', 'route' => 'products.index', 'order_index' => 215, 'has_children' => false,
    ];

    protected $parentMenu = '';
}
