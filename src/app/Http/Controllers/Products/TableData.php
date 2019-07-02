<?php

namespace App\Http\Controllers\Products;

use Illuminate\Routing\Controller;
use LaravelEnso\Tables\app\Traits\Data;
use LaravelEnso\Products\app\Tables\Builders\ProductTable;

class TableData extends Controller
{
    use Data;

    protected $tableClass = ProductTable::class;
}
