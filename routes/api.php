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

Route::get('/churches','ChurchController@list');
Route::post('/churches','ChurchController@create');
Route::get('/churches/{id}','ChurchController@get');
Route::put('/churches/{id}','ChurchController@update');
Route::delete('/churches/{id}','ChurchController@delete');

Route::get('/addresses','AddressController@list');
Route::post('/addresses','AddressController@create');
Route::get('/addresses/{id}','AddressController@get');
Route::put('/addresses/{id}','AddressController@update');
Route::delete('/addresses/{id}','AddressController@delete');

