<?php

namespace LaravelEnso\Products\App\Http\Controllers\Pictures;

use Illuminate\Routing\Controller;
use LaravelEnso\Products\App\Http\Requests\ValidatePictureReorderRequest;
use LaravelEnso\Products\App\Models\Picture;

class Reorder extends Controller
{
    public function __invoke(ValidatePictureReorderRequest $request, Picture $picture)
    {
        $picture->reorder($request->get('newIndex'));
    }
}
