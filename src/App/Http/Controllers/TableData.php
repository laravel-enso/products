<?php

namespace LaravelEnso\Products\App\Http\Controllers;

use Illuminate\Routing\Controller;
use LaravelEnso\Products\App\Tables\Builders\ProductTable;
use LaravelEnso\Tables\App\Traits\Data;

class TableData extends Controller
{
    use Data;

    protected $tableClass = ProductTable::class;
}
