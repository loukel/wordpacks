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

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// Route::get('/home', 'HomeController@index')->name('home');

// Route::get('/', [App\Http\Controllers\PacksController::class, 'index'])->middleware('auth');
Route::get('/', 'PacksController@index')->name('packs.index')->middleware('auth');

Route::get('/create', 'PacksController@create')->name('packs.create')->middleware('auth');

Route::get('/{id}', 'PacksController@show')->name('packs.show')->middleware('auth');
