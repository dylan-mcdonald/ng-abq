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

Route::get("{provider}/authorize", function($provider) {
	return OAuth::authorize($provider);
});

Route::get("{provider}/login", function($provider) {
	OAuth::login($provider, function($user, $userDetails){
		dd($userDetails);
		$user->email = $userDetails->email;
		$user->save();
	});
});