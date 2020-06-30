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

Route::get('/', 'MatchController@index');
Route::group(['prefix' => 'sa', 'as' => 'sa.', 'namespace' => 'SingleApplication'], function () {
    Route::group(['prefix' => 'matches', 'as' => 'matches.'], function () {
        Route::get('/', 'MatchController@getMatchesByParameters')->name('get-matches-by-parameters');
    });
});
