<?php

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

Route::get('/', [
    'uses' => 'ShorterController@long',
    'as'   => 'root_path',
]);
Route::get('/{hash}', [
    'uses' => 'ShorterController@short',
    'as'   => 'short_path',
])->where('hash', '[0-9a-zA-Z]{6,6}');
