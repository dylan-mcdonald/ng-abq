<?php

/**
 * Profile API
 *
 * @author Skyler Rexroad <skyler.rexroad@gmail.com>
 *
 * @version 1.0.0
 **/

use Com\NgAbq\Beta;

require_once dirname(__DIR__, 2) . "/classes/autoload.php";
require_once dirname(__DIR__, 3) . "/lib/xsrf.php";
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
		//set XSRF cookie
		setXsrfCookie();

		if (empty($id) === false) {
			$profile = Beta\Profile::getProfileByProfileId($pdo, $id);
			if ($profile !== null) {
				$reply->data = $profile;
			}
		} else {

			$profiles = Beta\Profile::getAllProfiles($pdo) -> toArray();

			if($profiles !== null) {
				$reply->data = $profiles;
			}
		}
	}

		// TODO: Else if ... getProfileByProfileActivationToken
	  else if ($method === "PUT") {
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

		$profile = Beta\Profile::getProfileByProfileId($pdo, $id);
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
	} else if ($method === "POST") {

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

		  $profile = Beta\Profile::getProfileByProfileId($pdo, $id);
		  if ($profile === null) {
			  throw new \RuntimeException("Profile does not exist.", 404);
		  }

		  $profile->setProfileAdmin($requestObject->profileAdmin);
		  $profile->setProfileNameFirst($requestObject->profileNameFirst);
		  $profile->setProfileNameLast($requestObject->profileNameLast);
		  $profile->setProfileEmail($requestObject->profileEmail);
		  $profile->setProfileUserName($requestObject->profileUserName);

		  // create new profile and insert into the database
		  $profile = new Beta\Profile(null, $requestObject->profileAdmin, $requestObject->profileNameFirst, $requestObject->profileNameLast, $requestObject->profileEmail, $requestObject->profileUserName, $requestObject->profileSalt, $requestObject->profileHash, $requestObject->profileActivationToken);
		  $profile->insert($pdo);

		  // update reply
		  $reply->message = "Profile created ok";
	  }

		else if ($method === "DELETE") {
		verifyXsrf();

		$profile = Beta\Profile::getProfileByProfileId($pdo, $id);
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
