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


use App\Http\Middleware\AuthAPI;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['api']], function () {
    // Event
    Route::post('/event/create', 'Auth\User\UserController@getDataById');
    Route::get('/event/listOwn', 'Auth\User\UserController@getDataById');

    // Event Invitation
    Route::post('/event/invit/create', 'Auth\User\UserController@getDataById');
    Route::post('/event/invit/update', 'Auth\User\UserController@getDataById');
    Route::get('/event/getInvit', 'Auth\User\UserController@getDataById');

    // User Contact'
    Route::post('/user/contact/create', 'Auth\User\Contact\UserController@getDataById');
    Route::post('/user/contact/update', 'Auth\User\Contact\UserController@getDataById');
    Route::get('/user/contact/getContact', 'Auth\User\Contact\UserContactDataController@getContact');

    // User
    Route::get('/user/getDataById/{id}', 'UserDataController@getDataById');
});

Route::group(['middleware' => ['api']], function () {
    // User
    Route::post('/user/register', 'UserRegistrationController@create');
    Route::post('/user/login', 'UserConnectionController@login');
});