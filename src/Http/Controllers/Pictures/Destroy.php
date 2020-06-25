<?php

namespace LaravelEnso\Products\Http\Controllers\Pictures;

use Illuminate\Routing\Controller;
use LaravelEnso\Products\Models\Picture;

class Destroy extends Controller
{
    public function __invoke(Picture $picture)
    {
        $picture->delete();
    }
}
