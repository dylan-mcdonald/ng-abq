<?php
use Com\NgAbq\Beta;

require_once dirname( __DIR__, 2 ) . "/classes/autoload.php";
require_once dirname( __DIR__, 3 ) . "/lib/xsrf.php";
require_once( "/etc/apache2/encrypted-config/encrypted-config.php" );


/**
 * API for the Attendee class
 *
 * @author:Eliot Ostling <it.treugott@gmail.com>
 **/


if ( session_status() !== PHP_SESSION_ACTIVE ) {
	session_start();
}

//prepare an empty reply
$reply         = new stdClass();
$reply->status = 200;
$reply->data   = null;

try {
	// grab the mySQL connection
	$pdo = connectToEncryptedMySQL( "/etc/apache2/encrypted-config/ng-abq-dev.ini" );

	//determine which HTTP method was used
	$method = array_key_exists( "HTTP_X_HTTP_METHOD", $_SERVER ) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

	//sanitize input
	$id      = filter_input( INPUT_GET, "id", FILTER_VALIDATE_INT );
	$eventId = filter_input( INPUT_GET, "eventId", FILTER_VALIDATE_INT );
//	$attendeeEventId = filter_input( INPUT_GET, "attendeeEventId", FILTER_VALIDATE_INT );
//	$attendeeProfileId = filter_input( INPUT_GET, "attendeeProfileId", FILTER_VALIDATE_INT );

	//make sure the id is valid for methods that require it
	if ( ( $method === "DELETE" || $method === "PUT" ) && ( empty( $id ) === true || $id < 0 ) ) {
		throw( new InvalidArgumentException( "id cannot be empty or negative", 405 ) );
	}

	// handle GET request - .
	if ( $method === "GET" ) {
		//set XSRF cookie
		setXsrfCookie();

		if ( ( ! empty( $eventId ) === true ) && $eventId >= 0 ) {
			$attendees = Beta\Attendee::getAttendeesByEventId( $pdo, $eventId )->toArray();

			if ( $attendees !== null ) {
				$reply->data = $attendees;

			}
		} else if ( ( ! empty( $id ) === true ) && $id >= 0 ) {
			$attendee = Beta\Attendee::getAttendeeByAttendeeId( $pdo, $id );

			if ( $attendee !== null ) {
				$reply->data = $attendee;
			}
		} else {

			//get all attendees and update reply
			$attendees = Beta\Attendee::getAllAttendees( $pdo )->toArray();
			if ( $attendees !== null ) {
				$reply->data = $attendees;
			}
		}
	} else if ( $method === "DELETE" ) {
		verifyXsrf();

		$attendee = Beta\Attendee::getAttendeeByAttendeeId( $pdo, $id );
		if ( $attendee === null ) {
			throw( new RuntimeException( "", 404 ) );
		}

		$attendee->delete( $pdo, $id );

		// update reply
		$reply->message = "Attendee deleted.";

	} else if ( $method === "POST" ) {
		verifyXsrf();
		$requestContent = file_get_contents( "php://input" );
		$requestObject  = json_decode( $requestContent );

		// make sure the attendee data is available
		if ( empty( $requestObject->attendeeEventId ) === true && empty( $requestObject->attendeeProfileId ) === true ) {
			throw( new \InvalidArgumentException ( "no attendee data.", 404 ) );
		}

		// create new Image and insert into the database
		$attendee = new Beta\Attendee( null, $requestObject->attendeeEventId, $requestObject->attendeeProfileId );
		$attendee->insert( $pdo );

		// update reply
		$reply->message = "Attendee created ok";
	} else {
		throw ( new InvalidArgumentException( "Invalid HTTP method request" ) );
	}


} catch
( Exception $exception ) {
	$reply->status  = $exception->getCode();
	$reply->message = $exception->getMessage();
	$reply->trace   = $exception->getTraceAsString();
} catch( TypeError $typeError ) {
	$reply->status  = $typeError->getCode();
	$reply->message = $typeError->getMessage();
}

header( "Content-type: application/json" );
if ( $reply->data === null ) {
	unset( $reply->data );
}


echo json_encode( $reply );