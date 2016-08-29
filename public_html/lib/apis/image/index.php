<?php
use Com\NgAbq\Beta;

require_once dirname(__DIR__, 2) . "/classes/autoload.php";
require_once dirname(__DIR__, 2) . "/lib/xsrf.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");


/**
 * api for the image class
 *
 * @author Marlan Ball based on code by Elliot Murrey <emurrey@cnm.edu> parts of this code have been modified from Derek Mauldin <derek.e.mauldin from @see https://bootcamp-coders.cnm.edu/class-materials/php/writing-restful-apis/
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
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/cartridge.ini");

	//determine which HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

	//sanitize input
	$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

	//make sure the id is valid for methods that require it
	if(($method === "DELETE" || $method === "PUT") && (empty($id) === true || $id < 0)) {
		throw(new InvalidArgumentException("id cannot be empty or negative", 405));
	}


	// handle GET request - if id is present, that image is returned, otherwise all images are returned.
	if($method === "GET") {
		//set XSRF cookie
		setXsrfCookie();

		//get all images and update reply
		$images = ng-abq\Image::getAllImageFileNames($pdo);
				if($images !== null) {
					$reply->data = $images;
				}
			}
	else if($method === "PUT" || $method === "POST") {

			verifyXsrf();
			$requestContent = file_get_contents("php://input");
			$requestObject = json_decode($requestContent);

			//make sure image content is available
			if(empty($requestObject->imageFileName) === true) {
				throw(new \InvalidArgumentException ("no content for image.", 405));
			}

			//perform the actual put or post
			if($method === "PUT") {

				// retrieve the image to update
				$image = ng-abq\Image::getImageFileNameByImageId($pdo, $id);
				if($image === null) {
					throw(new RuntimeException("Image Does not exist", 404));
				}

				// put the new image file name into the image and update
				$image->setImageFileName($requestObject->imageFileName);
				$image->update($pdo);

				//update reply
				$reply->message = "Image updated ok";

			} else if($method === "POST") {

				// create new Image and insert into the database
				$image = new ng-abq\Image(null, $requestObject->imageFileName, $requestObject->imageType);
				$image->insert($pdo);

				// update reply
				$reply->message = "Image created ok";
			}
		} else if($method === "DELETE") {
			verifyXsrf();

			// retrieve the Image to be deleted
			$image = ng-abq\Image::getImageFileNameByImageId($pdo, $id);
			if($image === null) {
				throw(new RuntimeException("Image does not exist", 404));
			}//
// I should delete this delete?
			// delete image
			$image->delete($pdo);

			// update reply
			$reply->message = "Image deleted OK";
		} else {
			throw (new InvalidArgumentException("Invalid HTTP method request"));
		}
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