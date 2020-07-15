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

Route::post('/login', 'Auth\LoginController@login');

Route::post('/register', 'Auth\RegisterController@register');


Route::middleware('auth:api')->group(function () {
    Route::get('/churches', 'ChurchController@list');
    Route::post('/churches', 'ChurchController@create');
    Route::get('/churches/{id}', 'ChurchController@get');
    Route::put('/churches/{id}', 'ChurchController@update');
    Route::delete('/churches/{id}', 'ChurchController@delete');

    Route::get('/addresses', 'AddressController@list');
    Route::post('/addresses', 'AddressController@create');
    Route::get('/addresses/{id}', 'AddressController@get');
    Route::put('/addresses/{id}', 'AddressController@update');
    Route::delete('/addresses/{id}', 'AddressController@delete');

    Route::get('/audio-messages', 'AudioMessageController@list');
    Route::post('/audio-messages', 'AudioMessageController@create');
    Route::get('/audio-messages/{id}', 'AudioMessageController@get');
    Route::put('/audio-messages/{id}', 'AudioMessageController@update');
    Route::delete('/audio-messages/{id}', 'AudioMessageController@delete');

    Route::get('/events', 'EventController@list');
    Route::post('/events', 'EventController@create');
    Route::get('/events/{id}', 'EventController@get');
    Route::put('/events/{id}', 'EventController@update');
    Route::delete('/events/{id}', 'EventController@delete');


    Route::get('/heirachies', 'HeirachyController@list');
    Route::post('/heirachies', 'HeirachyController@create');
    Route::get('/heirachies/{id}', 'HeirachyController@get');
    Route::put('/heirachies/{id}', 'HeirachyController@update');
    Route::delete('/heirachies/{id}', 'HeirachyController@delete');


    Route::get('/heirachy-groups', 'HeirachyGroupController@list');
    Route::post('/heirachy-groups', 'HeirachyGroupController@create');
    Route::get('/heirachy-groups/{id}', 'HeirachyGroupController@get');
    Route::put('/heirachy-groups/{id}', 'HeirachyGroupController@update');
    Route::delete('/heirachy-groups/{id}', 'HeirachyGroupController@delete');

    Route::get('/profile-media', 'ProfileMediaController@list');
    Route::post('/profile-media', 'ProfileMediaController@create');
    Route::get('/profile-media/{id}', 'ProfileMediaController@get');
    Route::put('/profile-media/{id}', 'ProfileMediaController@update');
    Route::delete('/profile-media/{id}', 'ProfileMediaController@delete');

    Route::get('/societies', 'SocietyController@list');
    Route::post('/societies', 'SocietyController@create');
    Route::get('/societies/{id}', 'SocietyController@get');
    Route::put('/societies/{id}', 'SocietyController@update');
    Route::delete('/societies/{id}', 'SocietyController@delete');
});


