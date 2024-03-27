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



//r1
Route::get('films','App\Http\Controllers\FilmController@index');
Route::get('films/{film_id}','App\Http\Controllers\FilmController@show');
//r2
Route::get('films/{film_id}/actors', 'App\Http\Controllers\Actor_FilmController@index');
//r3
Route::get('films/{film_id}/critics','App\Http\Controllers\CriticController@index');
//r4
Route::post('users', 'App\Http\Controllers\UserController@store');
//r5
Route::put('users/{film_id}', 'App\Http\Controllers\UserController@update');
//r6
Route::delete('films/{film_id}/critics/{critic_id}','App\Http\Controllers\UserController@delete');
//r7
Route::get('films/{id}/average', 'App\Http\Controllers\FilmController@calculateAvg');
//r8
Route::get('user/{id}/language', 'App\Http\Controllers\UserController@favoriteLanguage');
Route::get('films/search', 'App\Http\Controllers\FilmController@search');


Route::get('/languages', 'App\Http\Controllers\LanguageController@index');

Route::get('users', 'App\Http\Controllers\UserController@index');
Route::get('users/{id}','App\Http\Controllers\UserController@show');


/*

Route::get('actors', 'App\Http\Controllers\ActorController@index');
Route::get('actors/{id}','App\Http\Controllers\ActorController@show');

Route::get('actors-films', 'App\Http\Controllers\UserController@index');
Route::get('actors-films/{id}','App\Http\Controllers\UserController@show');

Route::get('critics', 'App\Http\Controllers\CriticController@index');
Route::get('critics/{id}','App\Http\Controllers\UserController@show');*/
