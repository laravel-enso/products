<?php

namespace LaravelEnso\Products\app\Http\Controllers\Products;

use Illuminate\Routing\Controller;
use LaravelEnso\Companies\app\Models\Company;
use LaravelEnso\Select\app\Traits\OptionsBuilder;
use LaravelEnso\Products\app\Http\Resources\Company as Resource;

class Suppliers extends Controller
{
    use OptionsBuilder;

    protected $model = Company::class;

    protected $resource = Resource::class;
}
