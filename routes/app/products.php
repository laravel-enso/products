<?php

use Illuminate\Support\Facades\Route;
use LaravelEnso\Products\Http\Controllers\Create;
use LaravelEnso\Products\Http\Controllers\Destroy;
use LaravelEnso\Products\Http\Controllers\Edit;
use LaravelEnso\Products\Http\Controllers\ExportExcel;
use LaravelEnso\Products\Http\Controllers\InitTable;
use LaravelEnso\Products\Http\Controllers\Options;
use LaravelEnso\Products\Http\Controllers\Store;
use LaravelEnso\Products\Http\Controllers\Suppliers;
use LaravelEnso\Products\Http\Controllers\TableData;
use LaravelEnso\Products\Http\Controllers\Update;

Route::get('create', Create::class)->name('create');
Route::post('', Store::class)->name('store');
Route::get('{product}/edit', Edit::class)->name('edit');
Route::patch('{product}', Update::class)->name('update');
Route::delete('{product}', Destroy::class)->name('destroy');

Route::get('initTable', InitTable::class)->name('initTable');
Route::get('tableData', TableData::class)->name('tableData');
Route::get('exportExcel', ExportExcel::class)->name('exportExcel');

Route::get('options', Options::class)->name('options');
Route::get('suppliers', Suppliers::class)->name('suppliers');
