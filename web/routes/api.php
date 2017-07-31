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

Route::group(['middleware' => ['api']], function () {
    // Event
    Route::post('/event/create', 'Auth\Event\EventCreationController@create');
    Route::get('/event/listOwn', 'Auth\Event\EventListController@getEventOwnUserList');

    // Event Invitation
    Route::post('/event/invit/create', 'Auth\User\EventInvitationCreationController@create');
    Route::post('/event/invit/update', 'Auth\User\EventInvitationUpdateController@update');
    Route::get('/event/getInvit', 'Auth\User\EventInvitationDataController@getUserInvitList');

    // User Contact'
    Route::post('/user/contact/create', 'Auth\User\Contact\UserContactCreationController@create');
    Route::post('/user/contact/update', 'Auth\User\Contact\UserContactUpdateController@update');
    Route::get('/user/contact/getContact', 'Auth\User\Contact\UserContactDataController@getUserContactList');

    // User
    Route::get('/user/getDataById/{id}', 'Auth\User\UserDataController@getDataById');
});

Route::group(['middleware' => ['api']], function () {
    // User
    Route::post('/user/register', 'UserRegistrationController@create');
    Route::post('/user/login', 'UserConnectionController@login');
});