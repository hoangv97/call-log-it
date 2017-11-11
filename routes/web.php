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

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

Route::get('/requests', 'TicketController@index')->name('request.index');
Route::get('/requests/create', 'TicketController@create')->name('request.create');
Route::get('/requests/edit', 'TicketController@edit')->name('request.edit');
