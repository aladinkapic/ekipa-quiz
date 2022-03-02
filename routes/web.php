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

Route::group(['namespace' => 'Quiz', 'prefix' => '/'], function () {
    Route::get('',                     'QuizController@index')->name('quiz.index');
});

Route::group(['namespace' => 'System', 'prefix' => '/system'], function () {
    Route::get('',                     'MainController@index')->name('system.index');
});

//Route::get('/', function () {
//    return view('welcome');
//});
