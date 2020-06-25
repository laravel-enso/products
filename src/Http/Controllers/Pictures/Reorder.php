<?php

namespace LaravelEnso\Products\Http\Controllers\Pictures;

use Illuminate\Routing\Controller;
use LaravelEnso\Products\Http\Requests\ValidatePictureReorderRequest;
use LaravelEnso\Products\Models\Picture;

class Reorder extends Controller
{
    public function __invoke(ValidatePictureReorderRequest $request, Picture $picture)
    {
        $picture->reorder($request->get('newIndex'));
    }
}
