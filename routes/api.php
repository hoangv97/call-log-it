<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('tickets', 'TicketApiController@getTickets')->name('tickets.api');
Route::get('tickets/info', 'TicketApiController@getInfoTicket')->name('tickets.info');
Route::post('tickets/update', 'TicketApiController@update')->name('tickets.update');

Route::get('employees', 'EmployeeController@searchEmployeesByName')->name('employees.api');
