<?php

namespace Com\NgAbq\Beta;
require_once("autoload.php");

/**
 * PHP representation of a user profile.
 *
 * Contains profile information and talks to the OauthIdentitiy class to determine login source.
 *
 * @author Skyler Rexroad <skyler.rexroad@gmail.com>
 *
 * @version 1.0.0
 **/
class Profile implements \JsonSerializable {

	/* STATE VARIABLES */

	/**
	 * Primary key of profile
	 * @var int $profileId
	 **/
	private $profileId;

	/**
	 * Profile admin flag
	 * @var boolean $profileAdmin
	 **/
	private $profileAdmin;

	/**
	 * Profile's first name
	 * @var string $profileNameFirst
	 **/
	private $profileNameFirst;

	/**
	 * Profile's last name
	 * @var string $profileNameLast
	 **/
	private $profileNameLast;

	/**
	 * Profile's email
	 * @var string $profileEmail
	 **/
	private $profileEmail;

	/**
	 * Profile's username
	 * @var string $profileUserName
	 **/
	private $profileUserName;

	/* CONSTRUCTOR */

	/**
	 * Constructor for profile
	 *
	 * @param int|null $newProfileId, primary key, null if new profile
	 * @param boolean $newProfileAdmin, admin flag
	 * @param string $newProfileNameFirst, first name of human
	 * @param string $newProfileNameLast, last name of human
	 * @param string $newProfileEmail, email of human
	 * @param string $newProfileUserName, username of human
	 * @throws \InvalidArgumentException if argument does not cooperate
	 * @throws \RangeException if argument is out of bounds
	 * @throws \TypeError if type is invalid
	 * @throws \Exception to handle edge cases
	 **/
	public function __construct(int $newProfileId = null, boolean $newProfileAdmin, string $newProfileNameFirst, string $newProfileNameLast, string $newProfileEmail, string $newProfileUserName) {
		try {
			$this->setProfileId($newProfileId);
			$this->setProfileAdmin($newProfileAdmin);
			$this->setProfileNameFirst($newProfileNameFirst);
			$this->setProfileNameLast($newProfileNameLast);
			$this->setProfileEmail($newProfileEmail);
			$this->setProfileUserName($newProfileUserName);
		} catch(\InvalidArgumentException $invalidArgument) {
			// Rethrow the exception
			throw(new \InvalidArgumentException($invalidArgument->getMessage(), 0, $invalidArgument));
		} catch(\RangeException $range) {
			// Rethrow the exception
			throw(new \RangeException($range->getMessage(), 0, $range));
		} catch(\TypeError $typeError) {
			// Rethrow the exception
			throw(new \TypeError($typeError->getMessage(), 0, $typeError));
		} catch(\Exception $exception) {
			// Rethrow the exception
			throw new \Exception($exception->getMessage(), 0, $exception);
		}
	}

	/* ACCESSORS AND MUTATORS */

	/**
	 * Accessor for profile ID
	 * @return int|null primary key
	 **/
	public function getProfileId() {
		return $this->profileId;
	}

	/**
	 * Mutator for profile ID
	 * @param int|null $newProfileId, primary key
	 * @throws \RangeException if profile ID is not > 0
	 * @throws \TypeError if profile ID is not an integer
	 **/
	public function setProfileId(int $newProfileId = null) {
		// Let profile ID = null
		if ($newProfileId === null) {
			$this->profileId = null;
			return;
		}

		// Make sure profile ID > 0
		if ($newProfileId <= 0) {
			throw new \RangeException("Profile ID must be positive");
		}

		$this->profileId = $newProfileId;
	}

	/**
	 * Accessor for profile admin flag
	 * @return boolean admin flag
	 **/
	public function getProfileAdmin() {
		return $this->profileAdmin;
	}

	/**
	 * Mutator for profile admin flag
	 * @param boolean $newProfileId, admin flag
	 * @throws \TypeError if profile admin flag is not a boolean
	 **/
	public function setProfileAdmin(boolean $newProfileAdmin) {
		$this->profileAdmin = $newProfileAdmin;
	}

	/* PDO METHODS */

	/* JSON SERIALIZE */

	public function jsonSerialize() {
		$fields = get_object_vars($this);
		// unset($fields["profileEmailActivation"]);
		unset($fields["profileHash"]);
		unset($fields["profileSalt"]);
		return ($fields);
	}
}
