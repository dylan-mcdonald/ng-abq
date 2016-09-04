<?php

namespace Com\NgAbq\Beta;
require_once("autoload.php");

/**
 * PasswordReset class for keeping track of password resets.
 *
 * Shares information with the profile class.
 *
 * @author Marlan Ball <wyndows@earthlink.net>
 *
 * @version 1.0.0
 **/

class PasswordReset implements \JsonSerializable {

	use ValidateDate;

	/**
	 * id for password reset; this is the primary key
	 * @var int $passwordResetId
	 */
	private $passwordResetId;

	/**
	 * foreign key
	 * @var int $passwordResetProfileId
	 */
	private $passwordResetProfileId;

	/**
	 * foreign key
	 * @var string $passwordResetProfileEmail
	 */
	private $passwordResetProfileEmail;

	/**
	 * the token of the password reset
	 * @var string $passwordResetToken
	 */
	private $passwordResetToken;

	/**
	 * the date password reset is requested
	 * @var string $passwordResetTime
	 */
	private $passwordResetTime;

	/**
	 * Constructor for passwordReset
	 *
	 * @param int|null $newPasswordResetId, primary key, null if new passwordReset
	 * @param int $newPasswordResetProfileId, profile id of authorized access
	 * @param string $newPasswordResetProfileEmail, email of user requesting reset
	 * @param string $newPasswordResetToken, token for verifying reset
	 * @param \DateTime|string|null $newPasswordResetTime, time of reset or null if set to current date and time
	 * @throws \InvalidArgumentException if argument does not cooperate
	 * @throws \RangeException if argument is out of bounds
	 * @throws \TypeError if type is invalid
	 * @throws \Exception to handle edge cases
	 **/
	public function __construct(int $newPasswordResetId = null, int $newPasswordResetProfileId, string $newPasswordResetProfileEmail, string $newPasswordResetToken, $newPasswordResetTime = null) {
		try {
			$this->setPasswordResetId($newPasswordResetId);
			$this->setPasswordResetProfileId($newPasswordResetProfileId);
			$this->setPasswordResetProfileEmail($newPasswordResetProfileEmail);
			$this->setPasswordResetToken($newPasswordResetToken);
			$this->setPasswordResetTime($newPasswordResetTime);
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
	 * accessor method for password reset id
	 *
	 * @return int value of password reset id
	 */
	public function getPasswordResetId() {
		return ($this->passwordResetId);
	}

	/**
	 * mutator method for password reset id
	 *
	 * @param int|null $newPasswordResetId new value of password reset id
	 * @throws \RangeException if $newPasswordResetId is not positive
	 * @throws \TypeError if $newPasswordResetId is not an integer
	 */
	public function setPasswordResetId(int $newPasswordResetId = null) {
		// base case: if the password reset id is null, this is a new password reset without a mySQL assigned id
		if($newPasswordResetId === null) {
			$this->passwordResetId = null;
			return;
		}

		// verify the password reset id is positive
		if($newPasswordResetId <= 0) {
			throw(new \RangeException("password reset id is not positive"));
		}

		// store the password reset id
		$this->passwordResetId = $newPasswordResetId;

	}

	/**
	 * accessor method for password reset profile id
	 *
	 * @return int value of password reset profile id
	 */

	public function getPasswordResetProfileId() {
		return ($this->passwordResetProfileId);
	}

	/**
	 * mutator method for password reset profile id
	 *
	 * @param int|null $newPasswordResetProfileId new value of password reset profile id
	 * @throws \RangeException if $newPasswordResetProfileId is not positive
	 * @throws \TypeError if $newPasswordResetProfileId is not an integer
	 */
	public function setPasswordResetProfileId(int $newPasswordResetProfileId) {
		// verify the passwordResetProfileId is positive
		if($newPasswordResetProfileId <= 0) {
			throw(new \RangeException("password reset profile id is not positive"));
		}

		// convert and store the password reset profile id
		$this->passwordResetProfileId = $newPasswordResetProfileId;
	}

	/**
	 * accessor method for password reset profile email
	 *
	 * @return string value of password reset profile email
	 */
	public function getPasswordResetProfileEmail() {
		return ($this->passwordResetProfileEmail);
	}

	/**
	 * mutator method for password reset profile email
	 *
	 * @param string $newPasswordResetProfileEmail new value of password reset profile email
	 * @throws \InvalidArgumentException if $newPasswordResetProfileEmail is not a string or insecure
	 * @throws \RangeException if $newPasswordResetProfileEmail is > 25 characters
	 * @throws \TypeError if $newPasswordResetProfileEmail is not a string
	 */
	public function setPasswordResetProfileEmail(string $newPasswordResetProfileEmail) {
		// verify the password reset profile email is secure
		$newPasswordResetProfileEmail = trim($newPasswordResetProfileEmail);
		$newPasswordResetProfileEmail = filter_var($newPasswordResetProfileEmail, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newPasswordResetProfileEmail) === true) {
			throw(new \InvalidArgumentException("passwordReset profile email is empty or insecure"));
		}

		// verify the password reset profile email will fit in the database
		if(strlen($newPasswordResetProfileEmail) > 25) {
			throw(new \RangeException("password reset profile email is too long"));
		}

		// store the password reset profile email
		$this->passwordResetProfileEmail = $newPasswordResetProfileEmail;
	}

	/**
	 * accessor method for password reset token
	 *
	 * @return string value of password reset token
	 */
	public function getPasswordResetToken() {
		return ($this->passwordResetToken);
	}

	/**
	 * mutator method for password reset token
	 *
	 * @param string $newPasswordResetToken new value of password reset token
	 * @throws \InvalidArgumentException if $newPasswordResetToken is not a string or insecure
	 * @throws \RangeException if $newPasswordResetToken is > 50 characters
	 * @throws \TypeError if $newPasswordResetToken is not a string
	 */
	public function setPasswordResetToken(string $newPasswordResetToken) {
		// verify the password reset token is secure
		$newPasswordResetToken = trim($newPasswordResetToken);
		$newPasswordResetToken = filter_var($newPasswordResetToken, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newPasswordResetToken) === true) {
			throw(new \InvalidArgumentException("password reset token is empty or insecure"));
		}

		// verify the password reset token will fit in the database
		if(strlen($newPasswordResetToken) > 50) {
			throw(new \RangeException("password reset token is too long"));
		}

		// store the password reset token
		$this->passwordResetToken = $newPasswordResetToken;
	}

	/**
	 * accessor method for password reset time
	 *
	 * @return \DateTime value of password reset time
	 **/
	public function getPasswordResetTime() {
		return($this->passwordResetTime);
	}

	/**
	 * mutator method for password reset time
	 *
	 * @param \DateTime|string|null $newPasswordResetTime as a DateTime object or string (or null to load the current time)
	 * @throws \InvalidArgumentException if $newPasswordResetTime is not a valid object or string
	 * @throws \RangeException if $newPasswordResetTime is a date that does not exist
	 **/
	public function setPasswordResetTime($newPasswordResetTime = null) {
		// base case: if the date is null, use the current date and time
		if($newPasswordResetTime === null) {
			$this->passwordResetTime = new \DateTime();
			return;
		}

		// store the password reset time
		try {
			$newPasswordResetTime = $this->validateDate($newPasswordResetTime);
		} catch(\InvalidArgumentException $invalidArgument) {
			throw(new \InvalidArgumentException($invalidArgument->getMessage(), 0, $invalidArgument));
		} catch(\RangeException $range) {
			throw(new \RangeException($range->getMessage(), 0, $range));
		}
		$this->passwordResetTime = $newPasswordResetTime;
	}

// insert
	/**
	 * inserts password reset information into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 */
	public function insert(\PDO $pdo) {
		// enforce the password reset it is null (i.e., don't insert a password reset that already exists
		if($this->passwordResetId !== null) {
			throw(new \PDOException("not a new passwordReset"));
		}

		// create query template
		$query = "INSERT INTO passwordReset(passwordResetProfileId, passwordResetProfileEmail, passwordResetToken, passwordResetTime) VALUES(:passwordResetProfileId, :passwordResetProfileEmail, :passwordResetToken, :passwordResetTime)";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders in the template
		$formattedDate = $this->passwordResetTime->format("Y-m-d H:i:s");
		$parameters = ["passwordResetProfileId" => $this->passwordResetProfileId, "passwordResetProfileEmail" => $this->passwordResetProfileEmail, "passwordResetToken" => $this->passwordResetToken, "passwordResetTime" => $formattedDate];
		$statement->execute($parameters);

		// update the null passwordResetId with what mySQL just gave us
		$this->passwordResetId = intval($pdo->lastInsertId());
	}

	/**
	 * deletes this passwordReset from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 */
	public function delete(\PDO $pdo) {
		// enforce the passwordResetId is not null (don't delete a passwordReset that has just been inserted)
		if($this->passwordResetId === null) {
			throw(new \PDOException("unable to delete a passwordReset that does not exist"));
		}

		// create query template
		$query = "DELETE FROM passwordReset WHERE passwordResetId = :passwordResetId";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holder in the template
		$parameters = ["passwordResetId" => $this->passwordResetId];
		$statement->execute($parameters);
	}

	/**
	 * gets the passwordReset by passwordReset id
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param int $passwordResetId - passwordReset id to search for
	 * @return PasswordReset|null - passwordReset found or null if not
	 * @throws \PDOException when mySQL related error occurs
	 * @throws \TypeError when variables are not the correct data type
	 */

	public static function getPasswordResetByPasswordResetId(\PDO $pdo, int $passwordResetId) {
		// sanitize the passwordResetId before searching
		if($passwordResetId <= 0) {
			throw(new \PDOException("passwordReset id is not positive"));
		}
		// create query template
		$query = "SELECT passwordResetId, passwordResetProfileId, passwordResetProfileEmail, passwordResetToken, passwordResetTime FROM passwordReset WHERE passwordResetId = :passwordResetId";
		$statement = $pdo->prepare($query);

		// bind the passwordReset id to the place holder in the template
		$parameters = array("passwordResetId" => $passwordResetId);
		$statement->execute($parameters);

		// grab the passwordReset from mySQL
		try {
			$passwordReset = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$passwordReset = new PasswordReset($row["passwordResetId"], $row["passwordResetProfileId"], $row["passwordResetProfileEmail"], $row["passwordResetToken"], \DateTime::createFromFormat("Y-m-d H:i:s", $row["passwordResetTime"]));
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return ($passwordReset);
	}

	// get all passwordResets
	/**
	 * gets all passwordResets
	 *
	 * @param \PDO $pdo PDO connection object
	 * @return \SplFixedArray SplFixedArray of PasswordResets found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getAllPasswordResets(\PDO $pdo) {
		// create query template
		$query = "SELECT passwordResetId, passwordResetProfileId, passwordResetProfileEmail, passwordResetToken, passwordResetTime FROM passwordReset";
		$statement = $pdo->prepare($query);
		$statement->execute();

		// build an array of passwordResets
		$passwordResets = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$passwordReset = new PasswordReset($row["passwordResetId"], $row["passwordResetProfileId"], $row["passwordResetProfileEmail"], $row["passwordResetToken"], \DateTime::createFromFormat("Y-m-d H:i:s", $row["passwordResetTime"]));
				$passwordResets[$passwordResets->key()] = $passwordReset;
				$passwordResets->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($passwordResets);
	}

	/**
	 * formats the state variables for JSON serialization
	 *
	 * @return array resulting state variables to serialize
	 */
	public function jsonSerialize() {
		$fields = get_object_vars($this);
		return ($fields);
	}

}

