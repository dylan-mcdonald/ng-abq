<?php
namespace App\Exceptions;

trait AjaxExceptionHandler {
	/**
	 * reformats an exception for returning as a JSON error
	 *
	 * @param \Exception $exception exception to format
	 * @param array $errors errors from Laravel's validator
	 * @return \stdClass container with errors for JSON encoding
	 * @see https://github.com/illuminate/validation/blob/master/Validator.php Illuminate's Validator
	 **/
	protected function formatException(\Exception $exception, array $errors = []) {
		$message = implode("<br />", $errors);
		if(empty($message) === true) {
			$message = $exception->getMessage();
		}
		$reply = new \stdClass();
		$reply->status = 422;
		$reply->message = $message;
		return($reply);
	}
}