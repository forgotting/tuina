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

Route::get('/', function () {
    return view('index');
});

Route::get('/punch', 'PunchController@index');
Route::get('/punch/{id}', 'PunchController@user_punch');
Route::post('/punch/start_work/', 'PunchController@start');
Route::post('/punch/stop_work/', 'PunchController@stop');
Route::post('/punch/ajax_update', 'PunchController@ajaxUpdate');

Route::get('/quote/{id}', 'QuoteController@index');
Route::post('/quote/{id}', 'QuoteController@count');

Route::get('excel/export/punch/{id}/{year}-{month}','ExcelController@punchExport');
