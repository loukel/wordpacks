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


Route::name('packs.')->group(function() {
  Route::get('/', 'PacksController@index')->name('index');

  Route::post('/create', 'PacksController@create')->name('create')->middleware('auth');

  Route::prefix('{pack_id}')->group(function() {
    Route::get('/', 'PacksController@show')->name('show');

    Route::post('/update', 'PacksController@update')->name('update')->middleware('auth');

    Route::post('/add', 'PacksController@add')->name('add')->middleware('auth');

    Route::post('/edit/{word}', 'PacksController@edit')->name('edit')->middleware('auth');

    Route::delete('/delete/{word}', 'PacksController@delete')->name('delete')->middleware('auth');

    Route::delete('/', 'PacksController@destroy')->name('destroy')->middleware('auth');
  });

});


