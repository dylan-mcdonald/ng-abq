<?php

namespace App\Http\Controllers;

use Mail;
use App\User;
use App\Exceptions\AjaxExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ContactController extends Controller {
	use AjaxExceptionHandler;

	public function contact(Request $request) {
		$reply = new \stdClass();
		$reply->status = 200;
		$reply->message = "Thank you for reaching out. We'll be in touch shortly.";

		try {
			$errors = [];
			$input = $request->json()->all();
			$validator = Validator::make($input, ["name" => "required|max:256", "email" => "required|email|max:256", "subject" => "required|max:256", "message" => "required|max:1024"]);
			if($validator->fails()) {
				$errors = $validator->errors()->all();
				$this->throwValidationException($request, $validator);
			}

			$input["messageLines"] = explode("\n", $input["message"]);
			Mail::send("contact-email", $input, function($message) use($input) {
				$admins = User::where("admin", 1)->get();
				$names = $admins->pluck("name")->all();
				$recipients = $admins->pluck("email")->all();
				$message->subject("[Albuquerue Angular Contact Form] " . $input["subject"])
					->to($recipients, $names)
					->from($input["email"], $input["name"]);
			});
		} catch(\Exception $exception) {
			$reply = $this->formatException($exception, $errors);
		}

		return(response()->json($reply));
	}
}