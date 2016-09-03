<?php
use Com\NgAbq\Beta;

require_once dirname(__DIR__, 2) . "/classes/autoload.php";
require_once dirname(__DIR__, 3) . "/lib/xsrf.php";
require_once("/etc/apache2/encrypted-config/encrypted-config.php");


/**
 * api for the link class
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
	if(($method === "DELETE" || $method === "PUT") && (empty($id) === true || $id < 0)) {
		throw(new InvalidArgumentException("id cannot be empty or negative", 405));
	}

	// handle GET request - all links are returned.
	if($method === "GET") {
		//set XSRF cookie
		setXsrfCookie();

		//get all links and update reply
		$links = Beta\Link::getAllLinks($pdo);
		if($links !== null) {
			$reply->data = $links;
		}
	}
	else if($method === "POST") {

		verifyXsrf();
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);

		//make sure link content is available
		if(empty($requestObject->linkUrl) === true) {
			throw(new \InvalidArgumentException ("no content for link.", 405));
		}

		//perform the actual post
		if($method === "POST") {

			// create new link and insert into the database
			$link = new Beta\Link(null, $requestObject->linkProfileId, $requestObject->linkProfileUserName, $requestObject->linkUrl, $requestObject->linkDate);
			$link->insert($pdo);

			// update reply
			$reply->message = "Link created ok";
		}
	} else if($method === "PUT") {
		verifyXsrf();

		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);

		//make sure link content is available
		if(empty($requestObject->linkUrl) === true) {
			throw(new \InvalidArgumentException ("no content for link.", 405));
		}

		// retrieve the Link to be deleted
		$link = Beta\Link::getLinkByLinkId($pdo, $id);
		if($link === null) {
			throw(new RuntimeException("Link does not exist", 404));
		}
var_dump($requestObject);
		// put the new link url into the link and update
		$link->setLinkUrl($requestObject->linkUrl);

		// update link
		$link->update($pdo);

		// update reply
		$reply->message = "Link updated OK";
	}	else if($method === "DELETE") {
		verifyXsrf();

		// retrieve the Link to be deleted
		$link = Beta\Link::getLinkByLinkId($pdo, $id);
		if($link === null) {
			throw(new RuntimeException("Link does not exist", 404));
		}

		// delete link
		$link->delete($pdo);

		// update reply
		$reply->message = "Link deleted OK";
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