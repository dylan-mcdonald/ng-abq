<?php

namespace App\Http\Controllers\Auth;

use App\Exceptions\AjaxExceptionHandler;
use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller {
	/*
	|--------------------------------------------------------------------------
	| Registration & Login Controller
	|--------------------------------------------------------------------------
	|
	| This controller handles the registration of new users, as well as the
	| authentication of existing users. By default, this controller uses
	| a simple trait to add these behaviors. Why don't you explore it?
	|
	*/

	use AjaxExceptionHandler, AuthenticatesAndRegistersUsers, ThrottlesLogins;

	/**
	 * Create a new authentication controller instance.
	 *
	 * @return void
	 */
	public function __construct() {
//		$this->middleware('guest', ['except' => 'getLogout']);
	}

	/**
	 * Get a validator for an incoming registration request.
	 *
	 * @param  array $data
	 * @return \Illuminate\Contracts\Validation\Validator
	 */
	protected function validator(array $data) {
		return Validator::make($data, [
			'name' => 'required|max:255',
			'email' => 'required|email|max:255|unique:users',
			'password' => 'required|confirmed|min:6',
		]);
	}

	/**
	 * Create a new user instance after a valid registration.
	 *
	 * @param  array $data
	 * @return User
	 */
	protected function create(array $data) {
		return User::create([
			'name' => $data['name'],
			'email' => $data['email'],
			'password' => bcrypt($data['password']),
		]);
	}

	protected function authenticated(Request $request, User $user) {
		return redirect()->intended();
	}

	public function postLogin(Request $request) {
		// create template reply
		$reply = new \stdClass();
		$reply->status = 200;
		$reply->message = "user logged in OK";

		try {
			// validate the form data
			$credentials = $request->json()->all();
			$errors = [];
			$validator = Validator::make($credentials, ["email" => "required|email", "password" => "required"]);
			if($validator->fails()) {
				$errors = $validator->errors()->all();
				$this->throwValidationException($request, $validator);
			}

			// authenticate the user
			if (!Auth::attempt($credentials, $request->has("remember"))) {
				throw(new \UnexpectedValueException("invalid username/password", 401));
			}
			$this->authenticated($request, Auth::user());
		} catch(\Exception $exception) {
			$reply = $this->formatException($exception, $errors);
		}
		return (response()->json($reply, 200));
	}

	public function postRegister(Request $request) {
		$reply = new \stdClass();
		$reply->status = 200;
		$reply->message = "user signed up OK";

		try {
			$validator = $this->validator($request->json()->all());
			if($validator->fails()) {
				$this->throwValidationException($request, $validator);
			}
			$this->create($request->json()->all());
		} catch(\Exception $exception) {
			$reply = $this->formatException($exception, $validator->errors()->all());
		}
		return (response()->json($reply, 200));
	}
}
