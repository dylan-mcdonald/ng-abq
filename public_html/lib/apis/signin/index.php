<?php

/**
 * Signin API
 *
 * @author Skyler Rexroad <skyler.rexroad@gmail.com>
 *
 * @version 1.0.0
 **/

use Com\NgAbq\Beta\Profile;

require_once dirname(__DIR__, 2) . "/classes/autoload.php";
require_once dirname(__DIR__, 2) . "/lib/xsrf.php";
require_once("/etc/apache2/encrypted-config/encrypted-config.php");

// Verify the session and start it if it's not active
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}

$reply = new stdClass();
$reply->status = 200;
$reply->data = null;

try {
	$config = connectToEncryptedMySQL("/etc/apache2/encrypted-config/ng-abq-dev.ini");

	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

	$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

	if ($method === "POST") {
			verifyXsrf();

			$requestContent = file_get_contents("php://input");
			$requestObject = json_decode($requestContent);

			$invalidMessage = "Login or password is incorrect.";

			if (empty($requestObject->email) === true && empty($requestObject->username) === true) {
				throw new \InvalidArgumentException("Please enter a login.", 404);
			} else if (empty($requestObject->email) === false) {
				$email = filter_var($requestObject->email, FILTER_SANITIZE_EMAIL, FILTER_FLAG_NO_ENCODE_QUOTES);
			} else if (empty($requestObject->username) === false) {
				$username = filter_var($requestObject->username, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
			}
			if (empty($requestObject->password) === true) {
				throw new \InvalidArgumentException("Please enter a password", 404);
			} else {
				$password = filter_var($requestObject->password, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
			}

			$profile = null;
			if (isset($email)) {
				$profile = Profile::getProfileByString($pdo, "profileEmail", $email)[0]; // Grab only result since email is unique
			} else if (isset($username)) {
				$profile = Profile::getProfileByString($pdo, "profileUserName", $username)[0]; // Grab only result since username is unique
			}

			if ($profile === null) {
				throw new \InvalidArgumentException($invalidMessage, 405);
			}

			$hash =  hash_pbkdf2("sha512", $password, $profile->getProfileSalt(), 262144);

			if($hash !== $profile->getProfileHash()) {
				throw new \InvalidArgumentException($invalidMessage, 405);
			}

			$_SESSION["profile"] = $profile;
			$reply->message = "Successfully logged in!";
	} else {
		throw new \RuntimeException("Method not allowed.");
	}
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

echo json_encode($reply);
