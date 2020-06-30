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


Route::view('/', 'welcome')->name('welcome');

Route::prefix('customer')->group(function () {
    Route::view('create', 'welcome')->name('create');
    Route::view('{id}/read', 'welcome')->name('read');
    Route::view('{id}/update', 'welcome')->name('update');
    Route::view('{id}/delete', 'welcome')->name('delete');
});
