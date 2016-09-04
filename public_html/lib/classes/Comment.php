<?php

namespace Com\NgAbq\Beta;
require_once("autoload.php");

/**
 * PHP representation of a comment.
 *
 * Contains information about a comment on a forum post.
 *
 * @author Skyler Rexroad <skyler.rexroad@gmail.com> and Marlan Ball <wyndows@earthlink.net>
 *
 * @version 1.0.0
 **/
class Comment implements \JsonSerializable {

	/* STATE VARIABLES */

	/**
	 * Primary key of comment
	 * @var int $commentId
	 **/
	private $commentId;

	/**
	 * Comment profile user name
	 * @var string $commentProfileUserName
	 **/
	private $commentProfileUserName;

	/**
	 * Post id comment is associated with
	 * @var int $commentPostId
	 **/
	private $commentPostId;

	/**
	 * Comment submission
	 * @var string $commentSubmission
	 **/
	private $commentSubmission;

	/**
	 * Comment time
	 * @var \DateTime $commentTime
	 **/
	private $commentTime;

	//construct
	public function __construct(int $newCommentId = null, string $newCommentProfileUserName, int $newCommentPostId, string $newCommentSubmission, string $newCommentTime = null) {
		try {
			$this->setCommentId($newCommentId);
			$this->setCommentProfileUserName($newCommentProfileUserName);
			$this->setCommentPostId($newCommentPostId);
			$this->setCommentSubmission($newCommentSubmission);
			$this->setCommentTime($newCommentTime);
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

	// accessors and mutators
	/**
	 * accessor method for comment id
	 *
	 * @return int value of comment id
	 */
	public function getCommentId() {
		return ($this->commentId);
	}

	/**
	 * mutator method for comment id
	 *
	 * @param int|null $newCommentId new value of comment id
	 * @throws \RangeException if $newCommentId is not positive
	 * @throws \TypeError if $newCommentId is not an integer
	 */
	public function setCommentId(int $newCommentId = null) {
		// base case: if the comment id is null, this is a new comment without a mySQL assigned id
		if($newCommentId === null) {
			$this->commentId = null;
			return;
		}

		// verify the comment id is positive
		if($newCommentId <= 0) {
			throw(new \RangeException("comment id is not positive"));
		}

		// store the comment id
		$this->commentId = $newCommentId;

	}

	/**
	 * accessor method for comment profile username
	 *
	 * @return string value of comment profile username
	 */
	public function getCommentProfileUserName() {
		return ($this->commentProfileUserName);
	}

	/**
	 * mutator method for comment profile username
	 *
	 * @param string $newCommentProfileUserName new value of comment profile username
	 * @throws \InvalidArgumentException if $newCommentProfileUserName is not a string or insecure
	 * @throws \RangeException if $newCommentProfileUserName is > 25 characters
	 * @throws \TypeError if $newCommentProfileUserName is not a string
	 */
	public function setCommentProfileUserName(string $newCommentProfileUserName) {
		// verify the comment profile username is secure
		$newCommentProfileUserName = trim($newCommentProfileUserName);
		$newCommentProfileUserName = filter_var($newCommentProfileUserName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newCommentProfileUserName) === true) {
			throw(new \InvalidArgumentException("comment profile username is empty or insecure"));
		}

		// verify the comment profile username will fit in the database
		if(strlen($newCommentProfileUserName) > 25) {
			throw(new \RangeException("comment profile username is too long"));
		}

		// store the product description
		$this->commentProfileUserName = $newCommentProfileUserName;
	}

	/**
	 * accessor method for comment profile id
	 *
	 * @return int value of comment profile id
	 */

	public function getCommentProfileId() {
		return ($this->commentProfileId);
	}

	/**
	 * mutator method for comment profile id
	 *
	 * @param int|null $newCommentProfileId new value of comment profile id
	 * @throws \RangeException if $newCommentProfileId is not positive
	 * @throws \TypeError if $newCommentProfileId is not an integer
	 */
	public function setCommentProfileId(int $newCommentProfileId) {
		// verify the commentProfileId is positive
		if($newCommentProfileId <= 0) {
			throw(new \RangeException("commentProfileId is not positive"));
		}

		// convert and store the account id
		$this->commentProfileId = $newCommentProfileId;
	}

	/**
	 * accessor method for comment submission
	 *
	 * @return string value of comment submission
	 */
	public function getCommentSubmission() {
		return ($this->commentSubmission);
	}

	/**
	 * mutator method for comment submission
	 *
	 * @param string $newCommentSubmission new value of comment submission
	 * @throws \InvalidArgumentException if $newCommentSubmission is not a string or insecure
	 * @throws \RangeException if $newCommentSubmission is > 25 characters
	 * @throws \TypeError if $newCommentSubmission is not a string
	 */
	public function setCommentSubmission(string $newCommentSubmission) {
		// verify the comment submission is secure
		$newCommentSubmission = trim($newCommentSubmission);
		$newCommentSubmission = filter_var($newCommentSubmission, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newCommentSubmission) === true) {
			throw(new \InvalidArgumentException("comment submission is empty or insecure"));
		}

		// verify the comment submission will fit in the database
		if(strlen($newCommentSubmission) > 150) {
			throw(new \RangeException("comment submission is too long"));
		}

		// store the product description
		$this->commentSubmission = $newCommentSubmission;
	}

	/**
	 * accessor method for comment time
	 *
	 * @return \DateTime value of comment time
	 **/
	public function getCommentTime() {
		return ($this->commentTime);
	}

	/**
	 * mutator method for comment time
	 *
	 * @param \DateTime|string|null $newCommentTime purchase time as a DateTime object or string (or null to load the current time)
	 * @throws \InvalidArgumentException if $newCommentTime is not a valid object or string
	 * @throws \RangeException if $newCommentTime is  a time that does not exist
	 **/
	public function setCommentTime($newCommentTime = null) {
		// base case: if the time is null, use the current date and time
		if($newCommentTime === null) {
			$this->commentTime = new \DateTime();
			return;
		}

		// store the comment time
		try {
			$newCommentTime = $this->validateDate($newCommentTime);
		} catch(\InvalidArgumentException $invalidArgument) {
			throw(new \InvalidArgumentException($invalidArgument->getMessage(), 0, $invalidArgument));
		} catch(\RangeException $range) {
			throw(new \RangeException($range->getMessage(), 0, $range));
		}
		$this->commentTime = $newCommentTime;
	}
	//TODO
	public function jsonSerialize() {
		// TODO
	}
}
