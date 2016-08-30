<?php
use Com\NgAbq\Beta;

require_once dirname(__DIR__, 2) . "/classes/autoload.php";
require_once dirname(__DIR__, 2) . "/lib/xsrf.php";
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

    $pdo = connectToEncryptedMySQL("/etc/apache2/encrypted-config/encrypted-config.php");

    $method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

    $id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

    if (($method === "DELETE" || $method === "PUT") && (empty($id) === true || $id < 0)) {
        throw(new InvalidArgumentException("", 405));
    }

    if($method === "GET") {
        //set XSRF cookie
        setXsrfCookie();

       
    }

   
  


