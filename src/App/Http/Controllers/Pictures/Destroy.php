<?php

namespace LaravelEnso\Products\App\Http\Controllers\Pictures;

use Illuminate\Routing\Controller;
use LaravelEnso\Products\App\Models\Picture;

class Destroy extends Controller
{
    public function __invoke(Picture $picture)
    {
        $picture->delete();
    }
}
