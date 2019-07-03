<?php

use LaravelEnso\Migrator\app\Database\Migration;

class CreateStructureForProducts extends Migration
{
    protected $permissions = [
        ['name' => 'products.index', 'description' => 'Show index for products', 'type' => 0, 'is_default' => false],
        ['name' => 'products.create', 'description' => 'Create product', 'type' => 1, 'is_default' => false],
        ['name' => 'products.store', 'description' => 'Store a new product', 'type' => 1, 'is_default' => false],
        ['name' => 'products.show', 'description' => 'Show product', 'type' => 1, 'is_default' => false],
        ['name' => 'products.edit', 'description' => 'Edit product', 'type' => 1, 'is_default' => false],
        ['name' => 'products.update', 'description' => 'Update product', 'type' => 1, 'is_default' => false],
        ['name' => 'products.destroy', 'description' => 'Delete product', 'type' => 1, 'is_default' => false],
        ['name' => 'products.initTable', 'description' => 'Init table for product', 'type' => 0, 'is_default' => false],
        ['name' => 'products.tableData', 'description' => 'Get table data for product', 'type' => 0, 'is_default' => false],
        ['name' => 'products.exportExcel', 'description' => 'Export excel for product', 'type' => 0, 'is_default' => false],
        ['name' => 'products.options', 'description' => 'Get product options for select', 'type' => 0, 'is_default' => false],
    ];

    protected $menu = [
        'name' => 'Products', 'icon' => 'fab product-hunt', 'route' => 'products.index', 'order_index' => 210, 'has_children' => false,
    ];

    protected $parentMenu = '';
}
