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
	return view('index');
});

// Authentication routes...
Route::get("auth/login", "Auth\AuthController@getLogin");
Route::post("auth/login", "Auth\AuthController@postLogin");
Route::get("auth/logout", "Auth\AuthController@getLogout");

// Registration routes...
Route::get("auth/signup", "Auth\AuthController@getRegister");
Route::post("auth/signup", "Auth\AuthController@postRegister");

Route::get("{provider}/authorize", function($provider) {
	return OAuth::authorize($provider);
});

Route::get("{provider}/login", function($provider) {
	OAuth::login($provider, function($user, $userDetails) {
		$user->name = $userDetails->full_name;
		$user->email = $userDetails->email;
		$user->save();
	});
});