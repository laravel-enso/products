<?php

use Illuminate\Support\Facades\Route;

Route::namespace('Pictures')
    ->prefix('pictures')
    ->as('pictures.')
    ->group(function () {
        Route::get('{product}/index', 'Index')->name('index');
        Route::post('{product}/store', 'Store')->name('store');
        Route::delete('{picture}', 'Destroy')->name('destroy');
        Route::patch('{picture}/reorder', 'Reorder')->name('reorder');
    });
