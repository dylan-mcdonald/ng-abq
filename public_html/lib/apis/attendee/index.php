
<?php
use Com\NgAbq\Beta;

require_once dirname(__DIR__, 2) . "/classes/autoload.php";
require_once dirname(__DIR__, 3) . "/lib/xsrf.php";
require_once("/etc/apache2/encrypted-config/encrypted-config.php");


/**
 * API for the Attendee class
 *
 * @author:Eliot Ostling <it.treugott@gmail.com>
 **/


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

    // handle GET request - .
    if($method === "GET") {
        //set XSRF cookie
        setXsrfCookie();

        $attendee = Beta\Attendee::getAttendeetByAttendeeEventId($pdo,$attendeeEventId);
        if($attendee !== null) {
            $reply->data = $attendee;
        }
    }
    else if($method === "DELETE") {
        verifyXsrf();

        $attendee = Beta\Attendee::getAttendeetByAttendeeEventId($pdo, $attendeeEventId);
        if($attendee === null) {
            throw(new RuntimeException("", 404));
        }

        // delete link
        $attendee->delete($pdo,$attendeeEventId);

        // update reply
        $reply->message = "";
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