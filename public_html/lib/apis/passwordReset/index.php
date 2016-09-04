<?php
use Com\NgAbq\Beta;

require_once dirname(__DIR__, 2) . "/classes/autoload.php";
require_once dirname(__DIR__, 3) . "/lib/xsrf.php";
require_once("/etc/apache2/encrypted-config/encrypted-config.php");


/**
 * api for the PasswordReset class
 *
 * @author Marlan Ball, parts of this code have been modified from code by Derek Mauldin <derek.e.mauldin from @see https://bootcamp-coders.cnm.edu/class-materials/php/writing-restful-apis/
 **/

// verify the session, start if not active
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}

//prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;

try {
	// grab the mySQL connection
	$pdo = connectToEncryptedMySQL("/etc/apache2/encrypted-config/ng-abq-dev.ini");

	//determine which HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

	//sanitize input
	$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

	//make sure the id is valid for methods that require it
	if(($method === "DELETE") && (empty($id) === true || $id < 0)) {
		throw(new InvalidArgumentException("id cannot be empty or negative", 405));
	}

	// handle GET request - all passwordResets are returned.
	if($method === "GET") {
		//set XSRF cookie
		setXsrfCookie();

		//get all passwordResets and update reply
		$passwordResets = Beta\PasswordReset::getAllPasswordResets($pdo);
		if($passwordResets !== null) {
			$reply->data = $passwordResets;
		}
	} else if($method === "POST") {

		verifyXsrf();
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);

		//make sure passwordReset content is available
		if((empty($requestObject->passwordResetProfileId) === true) && (empty($requestObject->passwordResetProfileEmail) === true)) {
			throw(new \InvalidArgumentException ("no profile for passwordReset.", 405));
		}
		if(empty($requestObject->passwordResetToken) === true) {
			throw(new \InvalidArgumentException ("no password reset token.", 405));
		}

		//perform the actual post
		if($method === "POST") {

			// create new passwordReset and insert into the database
			$bytes = random_bytes(25);
			$requestObject->passwordResetToken = (bin2hex($bytes));
			var_dump(($requestObject->passwordResetToken));
			$passwordReset = new Beta\PasswordReset(null, $requestObject->passwordResetProfileId, $requestObject->passwordResetProfileEmail, $requestObject->passwordResetToken, $requestObject->passwordResetDate);
			$passwordReset->insert($pdo);

			// update reply
			$reply->message = "PasswordReset created ok";
		}
	} else if($method === "DELETE") {
		verifyXsrf();

		// retrieve the Password Reset to be deleted
		$passwordReset = Beta\PasswordReset::getPasswordResetByPasswordResetId($pdo, $id);
		if($passwordReset === null) {
			throw(new RuntimeException("Password Reset does not exist", 404));
		}

		// delete image
		$passwordReset->delete($pdo);

		// update reply
		$reply->message = "Password Reset deleted OK";
	} else {
		throw (new InvalidArgumentException("Invalid HTTP method request"));
	}


	// update reply with exception information
} catch(Exception $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
	$reply->trace = $exception->getTraceAsString();
} catch(TypeError $typeError) {
	$reply->status = $typeError->getCode();
	$reply->message = $typeError->getMessage();
}

header("Content-type: application/json");
if($reply->data === null) {
	unset($reply->data);
}

// encode and return reply to front end caller
echo json_encode($reply);