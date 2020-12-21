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

Route::get('/', 'PacksController@index')->name('packs.index');

Route::post('/create', 'PacksController@create')->name('packs.create')->middleware('auth');

Route::get('/{pack_id}', 'PacksController@show')->name('packs.show');

Route::post('/{pack_id}/update', 'PacksController@update')->name('packs.update')->middleware('auth');

Route::post('/{pack_id}/add', 'PacksController@add')->name('packs.add')->middleware('auth');

Route::post('/{pack_id}/edit/{word}', 'PacksController@edit')->name('packs.edit')->middleware('auth');

Route::delete('/{pack_id}/delete/{word}', 'PacksController@delete')->name('packs.delete')->middleware('auth');

Route::delete('/{pack_id}', 'PacksController@destroy')->name('packs.destroy')->middleware('auth');
