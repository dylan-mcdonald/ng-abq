<?php

namespace App\Http\Controllers;

use App\Event;
use App\Exceptions\AjaxExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class EventController extends Controller {
	use AjaxExceptionHandler;

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		$reply = new \stdClass();
		$reply->status = 200;
		$reply->data = Event::all();
		return(response()->json($reply));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request) {
		$reply = new \stdClass();
		$reply->status = 200;
		$reply->message = "Event created OK";

		try {
			$errors = [];
			if(Auth::user()->admin !== 1) {
				throw(new \RuntimeException("user is not authorized to create events", 403));
			}
			$input = $request->json()->all();
			$validator = Validator::make($input, ["event_name" => "required|max:64", "event_description" => "required|max:255"]);
			if($validator->fails()) {
				$errors = $validator->errors()->all();
				$this->throwValidationException($request, $validator);
			}
			$event = new Event($input);
			$event->user_id = Auth::user()->id;
			$event->save();
		} catch(\Exception $exception) {
			$reply = $this->formatException($exception, $errors);
		}

		return(response()->json($reply));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id) {
		$reply = new \stdClass();
		$reply->status = 200;
		$reply->data = new \stdClass();

		try {
			$errors = [];
			$event = Event::find($id);
			if(empty($event) === false) {
				$reply->data = $event;
			}
		} catch(\Exception $exception) {
			$reply = $this->formatException($exception, $errors);
		}

		return(response()->json($reply));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  int $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id) {
		$reply = new \stdClass();
		$reply->status = 200;
		$reply->message = "Event updated OK";

		try {
			$errors = [];
			if(Auth::user()->admin !== 1) {
				throw(new \RuntimeException("user is not authorized to update events", 403));
			}

			$event = Event::find($id);
			if(empty($event) === true) {
				throw(new \RuntimeException("event does not exist"));
			}

			if(Auth::user()->id !== $event->user_id) {
				throw(new \RuntimeException("this object does not belong to this user"));
			}

			$input = $request->json()->all();
			$validator = Validator::make($input, ["event_name" => "required|max:64", "event_description" => "required|max:255"]);
			if($validator->fails()) {
				$errors = $validator->errors()->all();
				$this->throwValidationException($request, $validator);
			}
			$event->event_name = $input["event_name"];
			$event->event_description = $input["event_description"];
			$event->save();
		} catch(\Exception $exception) {
			$reply = $this->formatException($exception, $errors);
		}

		return(response()->json($reply));
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id) {
		$reply = new \stdClass();
		$reply->status = 200;
		$reply->message = "Event deleted OK";

		try {
			$errors = [];
			if(Auth::user()->admin !== 1) {
				throw(new \RuntimeException("user is not authorized to delete events", 403));
			}

			$event = Event::find($id);
			if(empty($event) === true) {
				throw(new \RuntimeException("event does not exist", 404));
			}
			$event->delete();
		} catch(\Exception $exception) {
			$reply = $this->formatException($exception, $errors);
		}

		return(response()->json($reply));
	}

	public function attend($id) {
		$reply = new \stdClass();
		$reply->status = 200;
		$reply->message = "Event attended OK";

		try {
			$errors = [];
			if(empty(Auth::user()) === true) {
				throw(new \RuntimeException("user is not logged in", 401));
			}
			$event = Event::find($id);
			if(empty($event) === true) {
				throw(new \RuntimeException("event does not exist", 404));
			}
			$event->attendees()->attach(Auth::user()->id);
		} catch(\Exception $exception) {
			$reply = $this->formatException($exception, $errors);
		}

		return(response()->json($reply));
	}

	public function miss($id) {
		$reply = new \stdClass();
		$reply->status = 200;
		$reply->message = "Event missed OK";

		try {
			$errors = [];
			if(empty(Auth::user()) === true) {
				throw(new \RuntimeException("user is not logged in", 401));
			}
			$event = Event::find($id);
			if(empty($event) === true) {
				throw(new \RuntimeException("event does not exist", 404));
			}
			$event->attendees()->detach(Auth::user()->id);
		} catch(\Exception $exception) {
			$reply = $this->formatException($exception, $errors);
		}

		return(response()->json($reply));
	}
}
