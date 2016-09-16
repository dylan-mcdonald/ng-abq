<?php

/**
 * Signout API
 *
 * @author Skyler Rexroad <skyler.rexroad@gmail.com>
 *
 * @version 1.0.0
 **/

// Verify the session and start it if it's not active
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}

$reply = new stdClass();
$reply->status = 200;
$reply->data = null;

try {
	if ($method === "GET") {
		$_SESSION = [];
		$reply->message = "Successfully signed out.";
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
