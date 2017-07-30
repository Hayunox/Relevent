<?php


/*
|--------------------------------------------------------------------------
| Api Routes
|--------------------------------------------------------------------------
|
| Here is where you can register Api routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your Api!
|
*/


use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth:api']], function () {
    // Event
    Route::post('/event/create', 'Auth\User\UserController@getDataById');
    Route::post('/event/listOwn', 'Auth\User\UserController@getDataById');

    // Event Invitation
    Route::post('/event/invit/create', 'Auth\User\UserController@getDataById');
    Route::post('/event/invit/update', 'Auth\User\UserController@getDataById');
    Route::get('/event/getInvit/{id}', 'Auth\User\UserController@getDataById');

    // User Contact'
    Route::post('/user/contact/create', 'Auth\User\Contact\UserController@getDataById');
    Route::post('/user/contact/update', 'Auth\User\Contact\UserController@getDataById');
    Route::get('/user/getContact/{id}', 'Auth\User\Contact\UserController@getDataById');

    // User
    Route::get('/user/getDataById/{id}', 'Auth\User\UserController@getDataById');
});

Route::group(['middleware' => ['guest:api']], function () {
    // User
    Route::get('/user/getDataById/{id}', 'UserDataController@getDataById');
    Route::post('/user/register', 'UserRegistrationController@create');
    Route::post('/user/login', 'UserConnectionController@login');
});