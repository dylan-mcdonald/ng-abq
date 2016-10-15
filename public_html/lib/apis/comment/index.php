<?php

/**
 * Comment API
 *
 * @author Skyler Rexroad <skyler.rexroad@gmail.com>
 *
 * @version 1.0.0
 **/

use Com\NgAbq\Beta;

require_once dirname( __DIR__, 2 ) . "/classes/autoload.php";
require_once dirname( __DIR__, 3 ) . "/lib/xsrf.php";
require_once( "/etc/apache2/encrypted-config/encrypted-config.php" );

// Verify the session and start it if it's not active
if ( session_status() !== PHP_SESSION_ACTIVE ) {
	session_start();
}

$reply         = new stdClass();
$reply->status = 200;
$reply->data   = null;

try {
	$pdo = connectToEncryptedMySQL( "/etc/apache2/encrypted-config/ng-abq-dev.ini" );

	$method = array_key_exists( "HTTP_X_HTTP_METHOD", $_SERVER ) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

	$id            = filter_input( INPUT_GET, "id", FILTER_VALIDATE_INT );
	$commentPostId = filter_input( INPUT_GET, "commentPostId", FILTER_VALIDATE_INT );

	if ( ( $method === "DELETE" || $method === "PUT" ) && ( empty( $id ) === true || $id < 0 ) ) {
		throw( new InvalidArgumentException( "", 405 ) );
	}

	if ( $method === "GET" ) {
		setXsrfCookie();

		if ( empty( $id ) === false ) {
			$comment = Beta\Comment::getCommentByCommentId( $pdo, $id );
			if ( $comment !== null ) {
				$reply->data = $comment;
			}
		} else if ( empty( $commentPostId ) === false ) {
			$comments = Beta\Comment::getCommentByCommentPostId( $pdo, $commentPostId );
			if ( $comments !== null ) {
				$reply->data = $comments;
			}
		} else {
			$comments = Beta\Comment::getAllComments( $pdo )->toArray();
			if ( sizeof( $comments ) > 0 ) {
				$reply->data = $comments;
			}
		}
	} else if ( $method === "PUT" || $method === "POST" ) {
		verifyXsrf();

		$requestContent = file_get_contents( "php://input" );
		$requestObject  = json_decode( $requestContent );

		if ( empty( $requestObject->commentPostId ) ) {
			throw new \InvalidArgumentException( "Comment post ID must exist.", 405 );
		}
		if ( empty( $requestObject->commentProfileUserName ) ) {
			throw new \InvalidArgumentException( "Comment profile username must exist.", 405 );
		}
		if ( empty( $requestObject->commentSubmission ) ) {
			throw new \InvalidArgumentException( "Comment content must exist.", 405 );
		}

		// BEGIN PUT AND POST
		if ( $method === "PUT" ) {
			$comment = Beta\Comment::getCommentByCommentId( $pdo, $id );

			if ( $comment === null ) {
				throw new \RuntimeException( "Comment does not exist.", 404 );
			}

			if(empty($requestObject->commentProfileUserName) !== true) {
				// put the new comment content into the feedback
				$comment->setCommentProfileUserName( $requestObject->commentProfileUserName );
			}
			if(empty($requestObject->commentPostId) !== true) {
				// put the new comment content into the feedback
				$comment->setCommentPostId( $requestObject->commentPostId );
			}
			if(empty($requestObject->commentSubmission) !== true) {
				// put the new comment content into the feedback
				$comment->setCommentSubmission( $requestObject->commentSubmission );
			}
var_dump($comment);
//			$comment->setCommentTime( $pdo, $requestObject->commentTime );

			$comment->update( $pdo );

			$reply->message = "Comment updated successfully.";
		} else if ( $method === "POST" ) {
			$comment = new Beta\Comment( null, $requestObject->commentProfileUserName, $requestObject->commentPostId, $requestObject->commentSubmission, $requestObject->commentTime );
			$comment->insert( $pdo );
			$reply->message = "Comment successfully posted.";
		}
	} else if ( $method === "DELETE" ) {
		verifyXsrf();

		$comment = Beta\Comment::getCommentByCommentId( $pdo, $id );
		if ( $comment === null ) {
			throw( new RuntimeException( "Comment does not exist.", 404 ) );
		}

		$comment->delete( $pdo );

		$reply->message = "Comment successfully deleted.";
	} else {
		throw new \RuntimeException( "Method not allowed." );
	}
} catch( Exception $exception ) {
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
