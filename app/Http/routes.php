<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::resource('data', 'DataController');

Route::post('users','UsersController@store');
Route::post('login','UsersController@login');
Route::get('users/{token}','UsersController@show');

Route::get('check', function() {
  return json_encode(array('status'=>'success','Connection succesfully'));
});
