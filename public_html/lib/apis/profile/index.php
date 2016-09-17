<?php

/**
 * Profile API
 *
 * @author Skyler Rexroad <skyler.rexroad@gmail.com>
 *
 * @version 1.0.0
 **/

use Com\NgAbq\Beta\Profile;

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

	$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

	if (($method === "DELETE" || $method === "PUT") && (empty($id) === true || $id < 0)) {
		throw(new InvalidArgumentException("", 405));
	}

	if ($method === "GET") {
		setXsrfCookie();

		if (empty($id) === false) {
			$profile = Profile::getProfileByProfileId($pdo, $id);
			if ($profile !== null) {
				$reply->data = $profile;
			}
		} // TODO: Else if ... getProfileByProfileActivationToken
	} else if ($method === "PUT") {
		verifyXsrf();

		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);

		if (empty($requestObject->profileAdmin)) {
			throw new \InvalidArgumentException("Profile admin flag must exist.", 405);
		}
		if (empty($requestObject->profileNameFirst)) {
			throw new \InvalidArgumentException("Profile first name must exist.", 405);
		}
		if (empty($requestObject->profileNameLast)) {
			throw new \InvalidArgumentException("Profile last name must exist.", 405);
		}
		if (empty($requestObject->profileEmail)) {
			throw new \InvalidArgumentException("Profile email must exist.", 405);
		}
		if (empty($requestObject->profileUserName)) {
			throw new \InvalidArgumentException("Profile username must exist.", 405);
		}

		$profile = Profile::getProfileByProfileId($pdo, $id);
		if ($profile === null) {
			throw new \RuntimeException("Profile does not exist.", 404);
		}

		$profile->setProfileAdmin($requestObject->profileAdmin);
		$profile->setProfileNameFirst($requestObject->profileNameFirst);
		$profile->setProfileNameLast($requestObject->profileNameLast);
		$profile->setProfileEmail($requestObject->profileEmail);
		$profile->setProfileUserName($requestObject->profileUserName);

		$profile->update($pdo);

		$reply->message = "Profile updated successfully.";
	} else if ($method === "DELETE") {
		verifyXsrf();

		$profile = Profile::getProfileByProfileId($pdo, $id);
		if($profile === null) {
			throw(new RuntimeException("Profile does not exist.", 404));
		}

		$profile->delete($pdo);

		$reply->message = "Profile successfully deleted.";
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
