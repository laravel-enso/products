<?php

namespace LaravelEnso\Products\Http\Controllers;

use Illuminate\Routing\Controller;
use LaravelEnso\Companies\Models\Company;
use LaravelEnso\Products\Http\Resources\Supplier;
use LaravelEnso\Select\Traits\OptionsBuilder;

class Suppliers extends Controller
{
    use OptionsBuilder;

    protected $model = Company::class;

    protected $resource = Supplier::class;
}
