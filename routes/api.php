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

    Route::get('/audio-posts', 'AudioPostController@list');
    Route::post('/audio-posts', 'AudioPostController@create');
    Route::get('/audio-posts/{id}', 'AudioPostController@get');
    Route::put('/audio-posts/{id}', 'AudioPostController@update');
    Route::delete('/audio-posts/{id}', 'AudioPostController@delete');


    Route::get('/video-posts', 'VideoPostController@list');
    Route::post('/video-posts', 'VideoPostController@create');
    Route::get('/video-posts/{id}', 'VideoPostController@get');
    Route::put('/video-posts/{id}', 'VideoPostController@update');
    Route::delete('/video-posts/{id}', 'VideoPostController@delete');

    Route::get('/events', 'EventController@list');
    Route::post('/events', 'EventController@create');
    Route::get('/events/{id}', 'EventController@get');
    Route::put('/events/{id}', 'EventController@update');
    Route::delete('/events/{id}', 'EventController@delete');
    Route::post('/events/{id}', 'EventController@attend');


    Route::get('/hierarchies', 'HierarchyController@list');
    Route::post('/hierarchies', 'HierarchyController@create');
    Route::get('/hierarchies/{id}', 'HierarchyController@get');
    Route::put('/hierarchies/{id}', 'HierarchyController@update');
    Route::delete('/hierarchies/{id}', 'HierarchyController@delete');


    Route::get('/hierarchy-groups', 'HierarchyGroupController@list');
    Route::post('/hierarchy-groups', 'HierarchyGroupController@create');
    Route::get('/hierarchy-groups/{id}', 'HierarchyGroupController@get');
    Route::put('/hierarchy-groups/{id}', 'HierarchyGroupController@update');
    Route::delete('/hierarchy-groups/{id}', 'HierarchyGroupController@delete');

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

    Route::get('/feed', 'FeedController@load');
});


