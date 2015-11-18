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

Route::get("/about", function() {
	return(view("about"));
});

Route::get("/contact", function() {
	return(view("contact"));
});

Route::get("/events", function() {
	return(view("events"));
});

Route::resource("/event", "EventController", ["only" => ["destroy", "index", "show", "store", "update"]]);
Route::post("/event/attend/{id}", "EventController@attend");
Route::delete("/event/attend/{id}", "EventController@miss");

// Authentication routes
Route::post("auth/signin", "Auth\AuthController@postLogin");
Route::get("auth/signout", "Auth\AuthController@getLogout");

// Registration routes
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
	return(redirect("/"));
});