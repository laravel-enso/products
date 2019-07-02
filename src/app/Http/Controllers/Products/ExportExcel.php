<?php

namespace LaravelEnso\Products\app\Http\Controllers\Products;

use Illuminate\Routing\Controller;
use LaravelEnso\Tables\app\Traits\Excel;
use LaravelEnso\Products\app\Tables\Builders\ProductTable;

class ExportExcel extends Controller
{
    use Excel;

    protected $tableClass = ProductTable::class;
}
