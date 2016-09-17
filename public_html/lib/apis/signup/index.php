<?php

/**
 * Post API
 *
 * @author Skyler Rexroad <skyler.rexroad@gmail.com>
 *
 * @version 1.0.0
 **/

use Com\NgAbq\Beta\Post;

require_once dirname(__DIR__, 2) . "/classes/autoload.php";
require_once dirname(__DIR__, 2) . "/xsrf.php";
require_once("/etc/apache2/encrypted-config/encrypted-config.php");

// Verify the session and start it if it's not active
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}

$reply = new stdClass();
$reply->status = 200;
$reply->data = null;

try {
	$pdo = connectToEncryptedMySQL("/etc/apache2/encrypted-config/ng-abq-dev.ini");

	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

	if ($method === "POST") {
		verifyXsrf();

		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);

		$profileAdmin = false;
		$profileNameFirst = $requestObject->profileNameFirst;
		$profileNameLast = $requestObject->profileNameLast;
		$profileEmail = $requestObject->profileEmail;
		$profileUserName = $requestObject->profileUserName;
		$password = $requestObject->password;
		$confirmPassword = $requestObject->confirmPassword;

		if (empty($profileNameFirst)) {
			throw new \InvalidArgumentException("Please provide profile first name.", 405);
		}
		if (empty($profileNameLast)) {
			throw new \InvalidArgumentException("Please provide profile last name.", 405);
		}
		if (empty($profileEmail)) {
			throw new \InvalidArgumentException("Please provide profile email.", 405);
		}
		if (empty($profileUserName)) {
			throw new \InvalidArgumentException("Please provide profile username", 405);
		}
		if (empty($password)) {
			throw new \InvalidArgumentException("Please provide password", 405);
		}
		if (empty($confirmPassword)) {
			throw new \InvalidArgumentException("Please confirm password.", 405);
		}

		if ($password !== $confirmPassword) {
			throw new \InvalidArgumentException("Passwords do not match.", 405);
		}

		$profileActivationToken = bin2hex(random_bytes(32));
		$salt = bin2hex(random_bytes(32));
		$hash = hash_pbkdf2("sha512", $password, $salt, 262144);

		$profile = new Profile(null, $profileAdmin, $profileNameFirst, $profileNameLast, $profileUserEmail, $profileUserName);
		$profile->insert($pdo);

		// TODO: Send confirmation email
		$reply->message = "Sign up was successful. Please check your email to complete the sign up process.";
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
