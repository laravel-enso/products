<?php

use LaravelEnso\Migrator\Database\Migration;

class CreateStructureForProducts extends Migration
{
    protected array $permissions = [
        ['name' => 'products.index', 'description' => 'Show index for products', 'is_default' => false],
        ['name' => 'products.create', 'description' => 'Create product', 'is_default' => false],
        ['name' => 'products.store', 'description' => 'Store a new product', 'is_default' => false],
        ['name' => 'products.edit', 'description' => 'Edit product', 'is_default' => false],
        ['name' => 'products.update', 'description' => 'Update product', 'is_default' => false],
        ['name' => 'products.destroy', 'description' => 'Delete product', 'is_default' => false],
        ['name' => 'products.initTable', 'description' => 'Init table for product', 'is_default' => false],
        ['name' => 'products.tableData', 'description' => 'Get table data for product', 'is_default' => false],
        ['name' => 'products.exportExcel', 'description' => 'Export excel for product', 'is_default' => false],
        ['name' => 'products.options', 'description' => 'Get product options for select', 'is_default' => false],
        ['name' => 'products.suppliers', 'description' => 'Get product supplier options for select', 'is_default' => false],
    ];

    protected array $menu = [
        'name' => 'Products', 'icon' => 'fab product-hunt', 'route' => 'products.index', 'order_index' => 215, 'has_children' => false,
    ];
}
