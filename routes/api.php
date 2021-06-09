<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['api', 'auth', 'core'])
    ->prefix('api/products')
    ->as('products.')
    ->group(function () {
        require __DIR__.'/app/products.php';
        require __DIR__.'/app/pictures.php';
    });
