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
    Route::get ('',                         'QuizController@index')->name('quiz.index');

    /*
     *  Currently active quiz
     */
    Route::get ('live-quiz/{id}',           'QuizController@live')->name('quiz.live');
    Route::post('answer-question',          'QuizController@answerQuestion')->name('quiz.live.answer-question');
});

Route::group(['namespace' => 'System', 'prefix' => '/system'], function () {
    Route::get('',                          'MainController@index')->name('system.index');

    Route::group(['namespace' => 'Quiz', 'prefix' => '/quiz'], function () {
        Route::get ('/',                         'QuizController@index')->name('system.quiz.index');
        Route::get ('/create',                   'QuizController@create')->name('system.quiz.create');
        Route::post('/save',                     'QuizController@save')->name('system.quiz.save');
        Route::get ('/preview/{id}',             'QuizController@preview')->name('system.quiz.preview');

        Route::group(['prefix' => '/sets'], function () {
            Route::get ('/create{quiz_id}',                         'SetsController@create')->name('system.quiz.sets.create');
            Route::get ('/preview{id}',                             'SetsController@preview')->name('system.quiz.sets.preview');
            Route::get ('/new-question{set_id}',                    'SetsController@newQuestion')->name('system.quiz.sets.new-question');
            Route::post('/save-question',                           'SetsController@saveQuestion')->name('system.quiz.sets.save-question');
            Route::get ('/delete-question{id}',                     'SetsController@deleteQuestion')->name('system.quiz.sets.delete-question');

            Route::group(['prefix' => '/players'], function () {
                Route::get ('/create{set_id}',                      'PlayersController@create')->name('system.quiz.sets.players.create');
                Route::post('/save',                                'PlayersController@save')->name('system.quiz.sets.players.save');

                Route::get ('/edit{id}',                            'PlayersController@edit')->name('system.quiz.sets.players.edit');
                Route::put ('/update',                              'PlayersController@update')->name('system.quiz.sets.players.update');
            });
        });
    });
});

//Route::get('/', function () {
//    return view('welcome');
//});
