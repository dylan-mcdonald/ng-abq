<?php
use Com\NgAbq\Beta\Event;

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

    if (($method === "DELETE" || $method === "PUT") && (empty($id) === true || $id < 0)) {
        throw(new InvalidArgumentException("", 405));
    }

    if ($method === "GET") {
        //set XSRF cookie
        setXsrfCookie();
        $events = Event::getAllEvents($pdo);
        if ($events !== null) {
            $reply->data = $events;
        }
        if ($events == null) {
        	var_dump($events);
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
        var_dump($requestObject);
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
  


