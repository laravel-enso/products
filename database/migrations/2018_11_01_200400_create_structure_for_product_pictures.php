<?php

use LaravelEnso\Migrator\Database\Migration;

class CreateStructureForProductPictures extends Migration
{
    protected array $permissions = [
        ['name' => 'products.pictures.index', 'description' => 'Show product pictures', 'is_default' => false],
        ['name' => 'products.pictures.store', 'description' => 'Upload product picture', 'is_default' => false],
        ['name' => 'products.pictures.destroy', 'description' => 'Delete product picture', 'is_default' => false],
        ['name' => 'products.pictures.reorder', 'description' => 'Reorder pictures', 'is_default' => false],
    ];
}
