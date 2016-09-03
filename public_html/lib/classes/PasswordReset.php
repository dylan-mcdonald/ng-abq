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
	 * @var string $passwordResetProfileUserName
	 */
	private $passwordResetProfileUserName;

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


	public function __construct(int $newPasswordResetId = null, int $newPasswordResetProfileId, string $newPasswordResetProfileUserName, string $newPasswordResetToken, $newPasswordResetTime = null) {
		try {
			$this->setPasswordResetId($newPasswordResetId);
			$this->setPasswordResetProfileId($newPasswordResetProfileId);
			$this->setPasswordResetProfileUserName($newPasswordResetProfileUserName);
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
	 * accessor method for password reset profile username
	 *
	 * @return string value of password reset profile username
	 */
	public function getPasswordResetProfileUserName() {
		return ($this->passwordResetProfileUserName);
	}

	/**
	 * mutator method for password reset profile username
	 *
	 * @param string $newPasswordResetProfileUserName new value of password reset profile username
	 * @throws \InvalidArgumentException if $newPasswordResetProfileUserName is not a string or insecure
	 * @throws \RangeException if $newPasswordResetProfileUserName is > 25 characters
	 * @throws \TypeError if $newPasswordResetProfileUserName is not a string
	 */
	public function setPasswordResetProfileUserName(string $newPasswordResetProfileUserName) {
		// verify the password reset profile username is secure
		$newPasswordResetProfileUserName = trim($newPasswordResetProfileUserName);
		$newPasswordResetProfileUserName = filter_var($newPasswordResetProfileUserName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newPasswordResetProfileUserName) === true) {
			throw(new \InvalidArgumentException("passwordReset profile username is empty or insecure"));
		}

		// verify the password reset profile username will fit in the database
		if(strlen($newPasswordResetProfileUserName) > 25) {
			throw(new \RangeException("password reset profile username is too long"));
		}

		// store the password reset profile username
		$this->passwordResetProfileUserName = $newPasswordResetProfileUserName;
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
		$query = "INSERT INTO passwordReset(passwordResetProfileId, passwordResetProfileUserName, passwordResetToken, passwordResetTime) VALUES(:passwordResetProfileId, :passwordResetProfileUserName, :passwordResetToken, :passwordResetTime)";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders in the template
		$formattedDate = $this->passwordResetTime->format("Y-m-d H:i:s");
		$parameters = ["passwordResetProfileId" => $this->passwordResetProfileId, "passwordResetProfileUserName" => $this->passwordResetProfileUserName, "passwordResetToken" => $this->passwordResetToken, "passwordResetTime" => $formattedDate];
		$statement->execute($parameters);

		// update the null passwordResetId with what mySQL just gave us
		$this->passwordResetId = intval($pdo->lastInsertId());
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

