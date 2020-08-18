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

    // Route::get('/', function () {
    //     return view('welcome');
    // });

    Route::get('/','CalendarController@index')->name('calendar');
    Route::get('/schedule','CalendarController@show')->name('schedule');
    Route::get('/create','CalendarController@create')->name('create');
    Route::post('/store','CalendarController@store')->name('store');
    Route::get('/edit/{id}','CalendarController@edit')->name('edit');
    Route::put('/update/{id}','CalendarController@update')->name('update');
    Route::get('/delete/{id}','CalendarController@delete')->name('delete');
