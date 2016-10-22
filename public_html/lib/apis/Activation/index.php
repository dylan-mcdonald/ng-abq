<?php

/**
 * Signin API
 *
 * @author Skyler Rexroad <skyler.rexroad@gmail.com>
 *
 * @version 1.0.0
 **/

use Com\NgAbq\Beta\Profile;

require_once dirname(__DIR__, 2) . "/classes/autoload.php";
require_once dirname(__DIR__, 2) . "/xsrf.php";
require_once("/etc/apache2/encrypted-config/encrypted-config.php");

// Verify the session and start it if it's not active
if(session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$reply = new stdClass();
$reply->status = 200;
$reply->data = null;

try {
//Grab MySQL connection
    $pdo = connectToEncryptedMySQL("/etc/apache2/encrypted-config/encrypted-config.php");
    $method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] :$_SERVER["REQUEST_METHOD"];
    if($method === "GET") {
//set Xsrf cookie
        setXsrfCookie("/");
        $profileActivationToken = $_GET["ActivationToken"];
        if(empty($profileActivationToken) === true|| ctype_xdigit($profileActivationToken) === false) {
            throw(new \RangeException ("No ActivationToken Code"));
        }
        $profile = profile::getProfileByProifleActivationToken($pdo, $profileActivationToken);
        if(empty($profile)) {
            throw(new \InvalidArgumentException ("nope"));
        }
        $profile->setProfileActivationToken(null);
        $profile->update($pdo);
        $reply->message = "Thank you This is halloween, I mean this is Angular!";
        $message = <<< EOF
<h1>Welcome to NG-Abq</h1>
EOF;

        $swiftMessage = Swift_Message::newInstance();
        $swiftMessage->setFrom(["it.treugott@gmail.com" => "Dylans"]);
        $recipients = [$user->getUserEmail() => $user->getUserFirstName() . " " . $user->getUserLastName()];
        $swiftMessage->setTo($recipients);
        $swiftMessage->setSubject("Welcome to ng abq, now you can never leave...ever...no seriously...your mine");
        $swiftMessage->setBody($message, "text/html");
        $swiftMessage->addPart(html_entity_decode($message), "text/plain");
        $smtp = Swift_SmtpTransport::newInstance("localhost", 25);
        $mailer = Swift_Mailer::newInstance($smtp);
        $numSent = $mailer->send($swiftMessage, $failedRecipients);
        if($numSent !== count($recipients)) {
            // the $failedRecipients parameter passed in the send() method now contains contains an array of the Emails that failed
            throw(new RuntimeException("unable to send email, rethink your life"));
        }
    } else {
        throw(new \Exception("Invalid HTTP method"));
    }
} catch(Exception $exception) {
    $reply->status = $exception->getCode();
    $reply->message = $exception->getMessage();
} catch(\TypeError $typeError) {
    $reply->status = $typeError->getCode();
    $reply->message = $typeError->getMessage();
}
header("Content-type: application/json");
echo json_encode($reply);