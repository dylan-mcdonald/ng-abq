<?php
use Com\NgAbq\Beta;

require_once dirname(__DIR__, 2) . "/classes/autoload.php";
require_once dirname(__DIR__, 3) . "/lib/xsrf.php";
require_once("/etc/apache2/encrypted-config/encrypted-config.php");


/**
 * api for the OauthIdentity class
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
	$profileId = filter_input(INPUT_GET, "profileId", FILTER_VALIDATE_INT);
	$oauthIdentityTimeStamp = filter_input(INPUT_GET, "oauthIdentityTimeStamp", FILTER_SANITIZE_STRING);

	//make sure the id is valid for methods that require it
	if(($method === "DELETE") && (empty($id) === true || $id < 0)) {
		throw(new InvalidArgumentException("id cannot be empty or negative", 405));
	}

	// handle GET request - all oauthIdentities are returned.
	if($method === "GET") {
		//set XSRF cookie
		setXsrfCookie();

		//get oauthIdentities and update reply
		if (empty($id) === false) {

			$oauthIdentity = Beta\OauthIdentity::getOauthIdentityByOauthIdentityId($pdo, $id);
			if ($oauthIdentity !== null) {
				$reply->data = $oauthIdentity;
			}
		} else if (empty($profileId) === false) {
			$oauthIdentities = Beta\OauthIdentity::getOauthIdentityByOauthIdentityProfileId($pdo, $profileId);
			if ($oauthIdentities !== null) {
				$reply->data = $oauthIdentities;
			}
		} else {
			$oauthIdentities = Beta\OauthIdentity::getOauthIdentityByOauthIdentityTimeStamp($pdo, $oauthIdentityTimeStamp)->toArray();
			if (sizeof($oauthIdentities) > 0) {
				$reply->data = $oauthIdentities;
			}
		}
	} else if($method === "POST") {

		verifyXsrf();
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);

		//make sure oauthIdentity content is available
		if((empty($requestObject->oauthIdentityProfileId) === true) && (empty($requestObject->oauthIdentityProfileEmail) === true)) {
			throw(new \InvalidArgumentException ("no profile for oauthIdentity.", 405));
		}
		if(empty($requestObject->oauthIdentityToken) === true) {
			throw(new \InvalidArgumentException ("no password reset token.", 405));
		}

		//perform the actual post
		if($method === "POST") {

			// create new oauthIdentity and insert into the database
			$bytes = random_bytes(25);
			$requestObject->oauthIdentityToken = (bin2hex($bytes));
			var_dump(($requestObject->oauthIdentityToken));
			$oauthIdentity = new Beta\OauthIdentity(null, $requestObject->oauthIdentityProfileId, $requestObject->oauthIdentityProfileEmail, $requestObject->oauthIdentityToken, $requestObject->oauthIdentityDate);
			$oauthIdentity->insert($pdo);

			// update reply
			$reply->message = "OauthIdentity created ok";
		}
	} else if($method === "DELETE") {
		verifyXsrf();

		// retrieve the Password Reset to be deleted
		$oauthIdentity = Beta\OauthIdentity::getOauthIdentityByOauthIdentityId($pdo, $id);
		if($oauthIdentity === null) {
			throw(new RuntimeException("Password Reset does not exist", 404));
		}

		// delete image
		$oauthIdentity->delete($pdo);

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