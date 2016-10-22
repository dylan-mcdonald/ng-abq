<?php


require_once(dirname(__DIR__, 2) . "/classes/autoload.php");
require_once("/etc/apache2/encrypted-config/encrypted-config.php");
//prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;
try {

    verifyXsrf();
    $requestContent = file_get_contents("php://input");
    $requestObject = json_decode($requestContent);
    if(empty($requestObject->name) === true && empty($requestObject->email) === true && empty($requestObject->subject) === true && empty($requestObject->message) === true) {
        throw(new \InvalidArgumentException ("No email info.", 405));
    }
    // create Swift message
    $swiftMessage = Swift_Message::newInstance();

    $swiftMessage->setFrom([$email => $name]);
    /**
     * attach the recipients to the message
     * $MAIL_RECIPIENTS is set in mail-config.php
     **/

    $recipients = $MAIL_RECIPIENTS;
    $swiftMessage->setTo($recipients);
    // attach the subject line to the message
    $swiftMessage->setSubject($subject);
    /**
     * attach the actual message to the message
     * here, we set two versions of the message: the HTML formatted message and a special filter_var()ed
     * version of the message that generates a plain text version of the HTML content
     * notice one tactic used is to display the entire $confirmLink to plain text; this lets users
     * who aren't viewing HTML content in Emails still access your links
     **/
    $swiftMessage->setBody($message, "text/html");
    $swiftMessage->addPart(html_entity_decode($message), "text/plain");
    /**
     * send the Email via SMTP; the SMTP server here is configured to relay everything upstream via CNM
     * this default may or may not be available on all web hosts; consult their documentation/support for details
     * SwiftMailer supports many different transport methods; SMTP was chosen because it's the most compatible and has the best error handling
     * @see http://swiftmailer.org/docs/sending.html Sending Messages - Documentation - SwitftMailer
     **/
    $smtp = Swift_SmtpTransport::newInstance("localhost", 25);
    $mailer = Swift_Mailer::newInstance($smtp);
    $numSent = $mailer->send($swiftMessage, $failedRecipients);
    /**
     * the send method returns the number of recipients that accepted the Email
     * so, if the number attempted is not the number accepted, this is an Exception
     **/
    if($numSent !== count($recipients)) {
        // the $failedRecipients parameter passed in the send() method now contains contains an array of the Emails that failed
        throw(new RuntimeException("unable to send email"));
    }
    // report a successful send
    $reply->message = "Email successfully sent.";
}
catch(\Exception $exception) {
    $reply->status = $exception->getCode();
    $reply->message = $exception->getMessage();
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