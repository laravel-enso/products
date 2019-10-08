<?php

namespace LaravelEnso\Products\app\Http\Controllers\Products;

use Illuminate\Routing\Controller;
use LaravelEnso\Companies\app\Models\Company;
use LaravelEnso\Products\app\Http\Resources\Company as Resource;
use LaravelEnso\Select\app\Traits\OptionsBuilder;

class Suppliers extends Controller
{
    use OptionsBuilder;

    protected $model = Company::class;

    protected $resource = Resource::class;
}
