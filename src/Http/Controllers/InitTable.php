<?php

namespace LaravelEnso\Products\Http\Controllers;

use Illuminate\Routing\Controller;
use LaravelEnso\Products\Tables\Builders\ProductTable;
use LaravelEnso\Tables\Traits\Init;

class InitTable extends Controller
{
    use Init;

    protected $tableClass = ProductTable::class;
}
