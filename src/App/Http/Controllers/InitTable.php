<?php

namespace LaravelEnso\Products\App\Http\Controllers;

use Illuminate\Routing\Controller;
use LaravelEnso\Products\App\Tables\Builders\ProductTable;
use LaravelEnso\Tables\App\Traits\Init;

class InitTable extends Controller
{
    use Init;

    protected $tableClass = ProductTable::class;
}
