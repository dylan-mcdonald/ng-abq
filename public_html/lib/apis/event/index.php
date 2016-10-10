<?php
use Com\NgAbq\Beta;

require_once dirname(__DIR__, 2) . "/classes/autoload.php";
require_once dirname(__DIR__, 3) . "/lib/xsrf.php";
require_once("/etc/apache2/encrypted-config/encrypted-config.php");


/**
 * api for the event class
 * @author Eliot Ostling
 **/

// verify the session, start if not active
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

    if ($method === "GET") {
        //set XSRF cookie
        setXsrfCookie();

		if (empty($id) === false) {
			$event = Beta\Event::getEventByEventId($pdo);
			if ($event !== null) {
				$reply->data = $event;
			}
		} else {
			$events = Beta\Event::getAllEvents($pdo) -> toArray();
			if($events !== null) {
				$reply->data = $events;
			}
		}
    }

    else if($method === "PUT") {
        verifyXsrf();

        $requestContent = file_get_contents("php://input");
        $requestObject = json_decode($requestContent);


        $events = Beta\Link::getEventByEventId($pdo, $id);
        if($events === null) {
            throw(new RuntimeException("", 404));
        }

        $events->setEventId($requestObject->EventId);

        // update link
        $events->update($pdo);

        // update reply
        $reply->message = "Events updated OK";
    }	else if($method === "DELETE") {
        verifyXsrf();

        // retrieve the Link to be deleted
        $events = Beta\Event::getEventByEventId($pdo, $id);
        if($events === null) {
            throw(new RuntimeException("", 404));
        }

        // delete link
        $events->delete($pdo);

        // update reply
        $reply->message = "Events deleted OK";
    } else {
        throw (new InvalidArgumentException("Invalid HTTP method request"));
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
