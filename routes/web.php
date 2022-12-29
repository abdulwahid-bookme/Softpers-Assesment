<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('/');
});

Route::controller(ExcelController::class)->group(function () {
    Route::get('/', 'index')->name('home');
    Route::get('/import', 'get_files')->name('importView');
    Route::post('/upload', 'upload')->name('upload');
    Route::get('/export/{file}', 'export')->name('export');
    Route::get('/view/{file}', 'file')->name('view');
});
