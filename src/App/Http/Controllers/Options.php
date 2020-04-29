<?php

namespace LaravelEnso\Products\App\Http\Controllers;

use Illuminate\Routing\Controller;
use LaravelEnso\Products\App\Models\Product;
use LaravelEnso\Select\App\Traits\OptionsBuilder;

class Options extends Controller
{
    use OptionsBuilder;

    protected $model = Product::class;
}
