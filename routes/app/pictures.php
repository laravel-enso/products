<?php

use Illuminate\Support\Facades\Route;
use LaravelEnso\Products\Http\Controllers\Pictures\Destroy;
use LaravelEnso\Products\Http\Controllers\Pictures\Index;
use LaravelEnso\Products\Http\Controllers\Pictures\Reorder;
use LaravelEnso\Products\Http\Controllers\Pictures\Store;

Route::prefix('pictures')
    ->as('pictures.')
    ->group(function () {
        Route::get('{product}/index', Index::class)->name('index');
        Route::post('{product}/store', Store::class)->name('store');
        Route::delete('{picture}', Destroy::class)->name('destroy');
        Route::patch('{picture}/reorder', Reorder::class)->name('reorder');
    });
