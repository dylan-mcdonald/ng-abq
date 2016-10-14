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

	use ValidateDate;

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
	/**
	 * constructor for this comment
	 *
	 * @param int|null $newCommentId , id of this comment
	 * @param string $newCommentProfileUserName , profile user name of user posting comment
	 * @param int $newCommentPostId , id of post being commented on
	 * @param string $newCommentSubmission , actual comment
	 * @param \DateTime|string|null $newCommentTime date and time comment was made or null if set to current date and time
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g. strings too long, negative integers)
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 */
	public function __construct(int $newCommentId = null, string $newCommentProfileUserName, int $newCommentPostId, string $newCommentSubmission, $newCommentTime = null) {
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
	 * accessor method for comment post id
	 *
	 * @return int value of comment post id
	 */

	public function getCommentPostId() {
		return ($this->commentPostId);
	}

	/**
	 * mutator method for comment post id
	 *
	 * @param int|null $newCommentPostId new value of comment post id
	 * @throws \RangeException if $newCommentPostId is not positive
	 * @throws \TypeError if $newCommentPostId is not an integer
	 */
	public function setCommentPostId(int $newCommentPostId) {

		// verify the commentPostId is positive
		if($newCommentPostId <= 0) {
			throw(new \RangeException("commentPostId is not positive"));
		}

		// convert and store the account id
		$this->commentPostId = $newCommentPostId;
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
	 * @throws \RangeException if $newCommentSubmission is > 150 characters
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

	/* PDO METHODS */

	public function insert(\PDO $pdo) {
		if ($this->commentId !== null) {
			throw new \PDOException("Cannot insert a comment which already exists.");
		}

		// Create query template
		$query = "INSERT INTO comment(commentProfileUserName, commentPostId, commentSubmission, commentTime) VALUES(:commentProfileUserName, :commentPostId, :commentSubmission, :commentTime)";
		$statement = $pdo->prepare($query);

		// Bind member variables to query
		$parameters = ["commentProfileUserName" => $this->commentProfileUserName, "commentPostId" => $this->commentPostId, "commentSubmission" => $this->commentSubmission, "commentTime" => $this->commentTime];
		$statement->execute($parameters);

		// Grab primary key from MySQL
		$this->commentId = intval($pdo->lastInsertId);
	}

	public function delete(\PDO $pdo) {
		if ($this->commentId === null) {
			throw new \PDOException("Cannot delete a comment which doesn't exist.");
		}

		// Create query template
		$query = "DELETE FROM comment WHERE commentId = :commentId";
		$statement = $pdo->prepare($query);

		// Bind member variables to query
		$parameters = ["commentId" => $this->commentId];
		$statement->execute($parameters);
	}

	public function update(\PDO $pdo) {
		if ($this->commentId === null) {
			throw new \PDOException("Cannot update a comment which doesn't exist.");
		}

		// Create query template
		$query = "UPDATE comment SET commentProfileUserName = :commentProfileUserName, commentPostId = :commentPostId,  commentSubmission = :commentSubmission, commentTime = :commentTime WHERE commentId = :commentId";
		$statement = $pdo->prepare($query);

		// Bind member variables to query
		$parameters = ["commentProfileUserName" => $this->commentProfileUserName, "commentPostId" => $this->commentPostId, "commentSubmission" => $this->commentSubmission, "commentTime" => $this->commentTime, "commentId" => $this->commentId];
		$statement->execute($parameters);
	}

	public static function getCommentByCommentId(\PDO $pdo, int $commentId) {
		if ($commentId <= 0) {
			throw new \PDOException("Not a valid comment ID.");
		}

		// Create query template
		$query = "SELECT commentId, commentProfileUserName, commentPostId, commentSubmission, commentTime FROM comment WHERE commentId = :commentId";
		$statement = $pdo->prepare($query);

		// Bind member variables to query
		$parameters = ["commentId" => $commentId];
		$statement->execute($parameters);

		try {
			$comment = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();

			if ($row !== false) {
				$comment = new Comment($row["commentId"], $row["commentPostId"], $row["commentSubmission"], \DateTime::createFromFormat("Y-m-d H:i:s", $row["commentTime"]));
			}
		} catch(\Exception $exception) {
			throw new \PDOException($exception->getMessage(), 0, $exception);
		}

		return $comment;
	}

	public static function getCommentByCommentPostId(\PDO $pdo, int $commentPostId) {
		if ($commentPostId <= 0) {
			throw new \PDOException("Not a valid post ID.");
		}

		// Create query template
		$query = "SELECT commentId, commentPostId, commentProfileUserName, commentSubmission, commentTime FROM comment WHERE commentPostId = :commentPostId";
		$statement = $pdo->prepare($query);

		// Bind member variables to query
		$parameters = ["commentPostId" => $commentPostId];
		$statement->execute($parameters);

		// Build an array of matches
		$comments = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);

		while (($row = $statement->fetch()) !== false) {
			try {
				$comment = new Comment($row["commentId"], $row["commentPostId"], $row["commentSubmission"], \DateTime::createFromFormat("Y-m-d H:i:s", $row["commentTime"]));

				$comments[$comments->key()] = $comment;
				$comment->next();
			} catch(\Exception $exception) {
				throw new \PDOException($exception->getMessage(), 0, $exception);
			}
		}

		return $comments;
	}

	public static function getCommentByCommentTime(\PDO $pdo, \DateTime $commentTime) {
		try {
			$commentTime = self::validateDateTime($commentTime);
		} catch(\Exception $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}

		// Create query template
		$query = "SELECT commentId, commentPostId, commentProfileUserName, commentSubmission, commentTime FROM comment WHERE commentTime = :commentTime";
		$statement = $pdo->prepare($query);

		// Bind member variables to query
		$parameters = ["commentTime" => $commentTime->format("Y-m-d H:i:s")];
		$statement->execute($parameters);

		// Build an array of matches
		$comments = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);

		while (($row = $statement->fetch()) !== false) {
			try {
				$comment = new Comment($row["commentId"], $row["commentPostId"], $row["commentSubmission"], \DateTime::createFromFormat("Y-m-d H:i:s", $row["commentTime"]));

				$comments[$comments->key()] = $comment;
				$comment->next();
			} catch(\Exception $exception) {
				throw new \PDOException($exception->getMessage(), 0, $exception);
			}
		}

		return $comments;
	}

	public static function getCommentByString(\PDO $pdo, string $attribute, string $search, bool $like = null) {
		$like = $like ? "LIKE" : "="; // Optionally search using "LIKE"
		$attribute = filter_var(trim($attribute), FILTER_SANITIZE_STRING);
		$search = filter_var(trim($search), FILTER_SANITIZE_STRING);

		if (empty($attribute) === true || empty($search) === true) {
			throw new \PDOException("Invalid string.");
		}

		// Create query template
		$query = "SELECT commentId, commentPostId, commentProfileUserName, commentSubmission, commentTime FROM comment WHERE :attribute $like :search";
		$statement = $pdo->prepare($query);

		// Bind member variables to query
		$parameters = ["attribute" => $attribute, "search" => $search];
		$statement->execute($parameters);

		// Build an array of matches
		$comments = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);

		while (($row = $statement->fetch()) !== false) {
			try {
				$comment = new Comment($row["commentId"], $row["commentPostId"], $row["commentSubmission"], \DateTime::createFromFormat("Y-m-d H:i:s", $row["commentTime"]));

				$comments[$comments->key()] = $comment;
				$comment->next();
			} catch(\Exception $exception) {
				throw new \PDOException($exception->getMessage(), 0, $exception);
			}
		}

		return $comments;
	}

	public static function getAllComments(\PDO $pdo) {
		// Create query template and execute

		$query = "SELECT commentId, commentProfileUserName, commentPostId, commentSubmission, commentTime FROM comment";
		$statement = $pdo->prepare($query);
		$statement->execute();

		// Build an array of matches
		$comments = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);

		while (($row = $statement->fetch()) !== false) {
			try {

				$comment = new Comment($row["commentId"], $row["commentProfileUserName"], $row["commentPostId"], $row["commentSubmission"], \DateTime::createFromFormat("Y-m-d H:i:s", $row["commentTime"]));

				$comments[$comments->key()] = $comment;
				$comments->next();
			} catch(\Exception $exception) {
				throw new \PDOException($exception->getMessage(), 0, $exception);
			}
		}

		return $comments;
	}

	/* JSON SERIALIZE */

	public function jsonSerialize() {
		$fields = get_object_vars($this);
		return ($fields);
	}
}
