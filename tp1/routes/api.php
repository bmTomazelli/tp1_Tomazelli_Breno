<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::get('films','App\Http\Controllers\FilmController@index');
Route::get('films/{id}','App\Http\Controllers\FilmController@show');
Route::post('films', 'App\Http\Controllers\FilmController@store');

Route::get('/languages', 'App\Http\Controllers\LanguageController@index');

