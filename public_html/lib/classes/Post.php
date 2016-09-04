<?php

namespace Com\NgAbq\Beta;
require_once("autoload.php");

/**
 * PHP representation of a post.
 *
 * Contains information about a forum post.
 *
 * @author Skyler Rexroad <skyler.rexroad@gmail.com>
 *
 * @version 1.0.0
 **/
class Post implements \JsonSerializable {

	/* STATE VARIABLES */

	/**
	 * Primary key of post
	 * @var int $postId
	 **/
	private $postId;

	/**
	 * Post profile user name
	 * @var string $postProfileUserName
	 **/
	private $postProfileUserName;

	/**
	 * Post submission
	 * @var string $postSubmission
	 **/
	private $postSubmission;

	/**
	 * Post time
	 * @var \DateTime $postTime
	 **/
	private $postTime;

	//construct
	public function __construct(int $newPostId = null, string $newPostProfileUserName, string $newPostSubmission, string $newPostTime = null) {
		try {
			$this->setPostId($newPostId);
			$this->setPostProfileUserName($newPostProfileUserName);
			$this->setPostSubmission($newPostSubmission);
			$this->setPostTime($newPostTime);
		} catch(\InvalidArgumentException $invalidArgument) {
			//rethrow the exception to the caller
			throw(new \InvalidArgumentException($invalidArgument->getMessage(), 0, $invalidArgument));
		} catch(\RangeException $range) {
			//rethrow the exception to the caller
			throw(new \RangeException($range->getMessage(), 0, $range));
		} catch(\TypeError $typeError) {
			//rethrow the exception to the caller
			throw(new \TypeError($typeError->getMessage(), 0, $typeError));
		} catch(\Exception $exception) {
			//rethrow the exception to the caller
			throw(new \Exception($exception->getMessage(), 0, $exception));
		}
	}

	//TODO
	public function jsonSerialize() {
		// TODO
	}
}
