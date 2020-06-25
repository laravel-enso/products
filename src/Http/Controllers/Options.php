<?php

namespace LaravelEnso\Products\Http\Controllers;

use Illuminate\Routing\Controller;
use LaravelEnso\Products\Models\Product;
use LaravelEnso\Select\Traits\OptionsBuilder;

class Options extends Controller
{
    use OptionsBuilder;

    protected $queryAttributes = ['name', 'part_number'];
    protected $model = Product::class;
}
