<?php

use LaravelEnso\Migrator\app\Database\Migration;

class CreateStructureForMeasurementUnits extends Migration
{
    protected $permissions = [
        ['name' => 'administration.measurementUnits.index', 'description' => 'Show index for measurement unit', 'type' => 0, 'is_default' => false],
        ['name' => 'administration.measurementUnits.create', 'description' => 'Create measurement unit', 'type' => 1, 'is_default' => false],
        ['name' => 'administration.measurementUnits.store', 'description' => 'Store a new measurement unit', 'type' => 1, 'is_default' => false],
        ['name' => 'administration.measurementUnits.edit', 'description' => 'Edit measurement unit', 'type' => 1, 'is_default' => false],
        ['name' => 'administration.measurementUnits.update', 'description' => 'Update measurement unit', 'type' => 1, 'is_default' => false],
        ['name' => 'administration.measurementUnits.destroy', 'description' => 'Delete measurement unit', 'type' => 1, 'is_default' => false],
        ['name' => 'administration.measurementUnits.initTable', 'description' => 'Init table for measurement unit', 'type' => 0, 'is_default' => false],
        ['name' => 'administration.measurementUnits.tableData', 'description' => 'Get table data for measurement unit', 'type' => 0, 'is_default' => false],
        ['name' => 'administration.measurementUnits.exportExcel', 'description' => 'Export excel for measurement unit', 'type' => 0, 'is_default' => false],
        ['name' => 'administration.measurementUnits.options', 'description' => 'Get measurement unit options for select', 'type' => 0, 'is_default' => false],
    ];

    protected $menu = [
        'name' => 'Measurement Units', 'icon' => 'ruler', 'route' => 'administration.measurementUnits.index', 'order_index' => 3, 'has_children' => false,
    ];

    protected $parentMenu = 'Administration';
}
