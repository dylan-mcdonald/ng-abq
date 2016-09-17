<?php

/**
 * Comment API
 *
 * @author Skyler Rexroad <skyler.rexroad@gmail.com>
 *
 * @version 1.0.0
 **/

use Com\NgAbq\Beta\Comment;

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
	$config = connectToEncryptedMySQL("/etc/apache2/encrypted-config/ng-abq-dev.ini");

	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

	$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

	if (($method === "DELETE" || $method === "PUT") && (empty($id) === true || $id < 0)) {
		throw(new InvalidArgumentException("", 405));
	}

	if ($method === "GET") {
		setXsrfCookie();

		if (empty($id) === false) {
			$comment = Comment::getCommentByCommentId($pdo, $id);
			if ($comment !== null) {
				$reply->data = $comment;
			}
		} else {
			$comments = Comment::getAllComments($pdo)->toArray();
			if (sizeof($comments) > 0) {
				$reply->data = $comments;
			}
		}
	} else if ($method === "PUT" || $method === "POST") {
		verifyXsrf();

		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);

		if (empty($requestObject->commentPostId)) {
			throw new \InvalidArgumentException("Comment post ID must exist.", 405);
		}
		if (empty($requestObject->commentProfileUserName)) {
			throw new \InvalidArgumentException("Comment profile username must exist.", 405);
		}
		if (empty($requestObject->commentSubmission)) {
			throw new \InvalidArgumentException("Comment content must exist.", 405);
		}
		if (empty($requestObject->commentTime)) {
			throw new \InvalidArgumentException("Comment timestamp must exist.", 405);
		}

		// BEGIN PUT AND POST
		if ($method === "PUT") {
			$comment = Comment::getCommentByCommentId($pdo, $id);
			if ($comment === null) {
				throw new \RuntimeException("Comment does not exist.", 404);
			}

			$comment->setCommentPostId($pdo, $requestObject->commentPostId);
			$comment->setCommentProfileUserName($pdo, $requestObject->commentProfileUserName);
			$comment->setCommentSubmission($pdo, $requestObject->commentSubmission);
			$comment->setCommentTime($pdo, $requestObject->commentTime);

			$post->update($pdo);

			$reply->message = "Comment updated successfully.";
		} else if ($method === "POST") {
			$comment = new Comment(null, $requestObject->commentPostId, $requestObject->commentProfileUserName, $requestObject->commentSubmission, $requestObject->commentTime);
			$comment->insert($pdo);

			$reply->message = "Comment successfully posted.";
		}
	} else if ($method === "DELETE") {
		verifyXsrf();

		$comment = Comment::getCommentByCommentId($pdo, $id);
		if($comment === null) {
			throw(new RuntimeException("Comment does not exist.", 404));
		}

		$comment->delete($pdo);

		$reply->message = "Comment successfully deleted.";
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
