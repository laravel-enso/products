<?php

namespace LaravelEnso\Products\App\Http\Controllers;

use Illuminate\Routing\Controller;
use LaravelEnso\Companies\App\Models\Company;
use LaravelEnso\Products\App\Http\Resources\Supplier;
use LaravelEnso\Select\App\Traits\OptionsBuilder;

class Suppliers extends Controller
{
    use OptionsBuilder;

    protected $model = Company::class;

    protected $resource = Supplier::class;
}
