<?php

namespace LaravelEnso\Products\Imports\Importers;

use Illuminate\Support\Facades\App;
use LaravelEnso\Categories\Models\Category as Model;
use LaravelEnso\DataImport\Contracts\Importable;
use LaravelEnso\DataImport\Models\DataImport;
use LaravelEnso\Helpers\Services\Obj;
use LaravelEnso\Products\Imports\Product;

class Category implements Importable
{
    public function run(Obj $row, DataImport $import)
    {
        $category = Model::cacheGetBy('name', $row->get('category'));

        App::make(Product::class)::get($row)
            ->update(['category_id' => $category->id]);
    }
}
