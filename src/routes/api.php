<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['web', 'auth', 'core'])
    ->namespace('LaravelEnso\Products\App\Http\Controllers')
    ->prefix('api/products')
    ->as('products.')
    ->group(function () {
        require 'products.php';
        require 'pictures.php';
    });
