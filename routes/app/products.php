<?php

use Illuminate\Support\Facades\Route;

Route::get('create', 'Create')->name('create');
Route::post('', 'Store')->name('store');
Route::get('{product}/edit', 'Edit')->name('edit');
Route::patch('{product}', 'Update')->name('update');
Route::delete('{product}', 'Destroy')->name('destroy');

Route::get('initTable', 'InitTable')->name('initTable');
Route::get('tableData', 'TableData')->name('tableData');
Route::get('exportExcel', 'ExportExcel')->name('exportExcel');

Route::get('options', 'Options')->name('options');
Route::get('suppliers', 'Suppliers')->name('suppliers');
