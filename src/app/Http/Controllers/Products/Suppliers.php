<?php

namespace LaravelEnso\Products\app\Http\Controllers\Products;

use Illuminate\Routing\Controller;
use LaravelEnso\Companies\app\Models\Supplier;
use LaravelEnso\Select\app\Traits\OptionsBuilder;
use LaravelEnso\Products\app\Http\Resources\Company as Resource;

class Suppliers extends Controller
{
    use OptionsBuilder;

    protected $model = Supplier::class;

    protected $resource = Resource::class;
}
