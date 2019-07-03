<?php

Route::middleware(['web', 'auth', 'core'])
    ->namespace('LaravelEnso\Products\app\Http\Controllers')
    ->prefix('api')
    ->group(function () {
        Route::prefix('administration')
            ->as('administration.')
            ->group(function () {
                Route::namespace('MeasurementUnits')
                    ->prefix('measurementUnits')
                    ->as('measurementUnits.')
                    ->group(function() {
                        Route::get('create', 'Create')->name('create');
                        Route::post('', 'Store')->name('store');
                        Route::get('{measurementUnit}/edit', 'Edit')->name('edit');
                        Route::patch('{measurementUnit}', 'Update')->name('update');
                        Route::delete('{measurementUnit}', 'Destroy')->name('destroy');
        
                        Route::get('initTable', 'InitTable')->name('initTable');
                        Route::get('tableData', 'TableData')->name('tableData');
                        Route::get('exportExcel', 'ExportExcel')->name('exportExcel');
        
                        Route::get('options', 'Options')->name('options');
                    });
            });

            Route::namespace('Products')
            ->prefix('products')
            ->as('products.')
            ->group(function () {
                Route::get('create', 'Create')->name('create');
                Route::post('', 'Store')->name('store');
                Route::get('{product}/edit', 'Edit')->name('edit');
                Route::patch('{product}', 'Update')->name('update');
                Route::delete('{product}', 'Destroy')->name('destroy');

                Route::get('initTable', 'InitTable')->name('initTable');
                Route::get('tableData', 'TableData')->name('tableData');
                Route::get('exportExcel', 'ExportExcel')->name('exportExcel');

                Route::get('options', 'Options')->name('options');
            });
    });
