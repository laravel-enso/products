<?php

Route::middleware(['web', 'auth', 'core'])
    ->namespace('LaravelEnso\Products\app\Http\Controllers')
    ->prefix('api')
    ->group(function () {
        require 'app/products.php';
    });
