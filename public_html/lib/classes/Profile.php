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
	 * @var bool $profileAdmin
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

    /**
     * salt set for this profile
     * @var string $profileSalt
     **/

    private $profileSalt;
    /**
     * last name of this profile
     * @var string $userLastName
     **/

    private $profileHash;

    /**
     * activation token for profile account
     * @var string $profileActivationToken
     **/
    private $profileActivationToken;


	/* CONSTRUCTOR */

	/**
	 * Constructor for profile
	 *
	 * @param int|null $newProfileId, primary key, null if new profile
	 * @param bool $newProfileAdmin, admin flag
	 * @param string $newProfileNameFirst, first name of human
	 * @param string $newProfileNameLast, last name of human
	 * @param string $newProfileEmail, email of human
	 * @param string $newProfileUserName, username of human
     * @param string $newProfileSalt, salts stuff
     * @param string $newProfileHash, the good hash
     * @param string $newProfileActivationToken, activation token
	 * @throws \InvalidArgumentException if argument does not cooperate
	 * @throws \RangeException if argument is out of bounds
	 * @throws \TypeError if type is invalid
	 * @throws \Exception to handle edge cases
	 **/
	public function __construct(int $newProfileId = null, int $newProfileAdmin, string $newProfileNameFirst, string $newProfileNameLast, string $newProfileEmail, string $newProfileUserName, string $newProfileSalt, string $newProfileHash, string $newProfileActivationToken) {
		try {
			$this->setProfileId($newProfileId);
			$this->setProfileAdmin($newProfileAdmin);
			$this->setProfileNameFirst($newProfileNameFirst);
			$this->setProfileNameLast($newProfileNameLast);
			$this->setProfileEmail($newProfileEmail);
			$this->setProfileUserName($newProfileUserName);
            $this->setProfileSalt($newProfileSalt);
            $this->setProfileHash($newProfileHash);
            $this->setProfileActivationToken($newProfileActivationToken);
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
	 * @return bool admin flag
	 **/
	public function getProfileAdmin() {
		return $this->profileAdmin;
	}

	/**
	 * Mutator for profile admin flag
	 * @param bool $newProfileAdmin, admin flag
	 * @throws \TypeError if profile admin flag is not a bool
	 **/
	public function setProfileAdmin(int $newProfileAdmin = 0) {
		$this->profileAdmin = $newProfileAdmin;
	}

	/**
	 * Accessor for profile first name
	 * @return string first name
	 **/
	public function getProfileNameFirst() {
		return $this->profileNameFirst;
	}

	/**
	 * Mutator for profile first name
	 * @param string $newProfileNameFirst, first name
	 * @throws \RangeException if profile first name is out of bounds
	 * @throws \TypeError if profile first name is not a string
	 **/
	public function setProfileNameFirst(string $newProfileNameFirst) {
		// Sanitize dat string
		$newProfileNameFirst = filter_var(trim($newProfileNameFirst), FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

		// Make sure profile first name exists and fits in database
		if (strlen($newProfileNameFirst) <= 0) {
			throw new \RangeException("Profile first name too short");
		} else if (strlen($newProfileNameFirst) > 50) {
			throw new \RangeException("Profile first name too long");
		}

		$this->profileNameFirst = $newProfileNameFirst;
	}

	/**
	 * Accessor for profile last name
	 * @return string last name
	 **/
	public function getProfileNameLast() {
		return $this->profileNameLast;
	}

	/**
	 * Mutator for profile last name
	 * @param string $newProfileNameLast, last name
	 * @throws \RangeException if profile last name is out of bounds
	 * @throws \TypeError if profile last name is not a string
	 **/
	public function setProfileNameLast(string $newProfileNameLast) {
		// Sanitize dat string
		$newProfileNameLast = filter_var(trim($newProfileNameLast), FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

		// Make sure profile last name exists and fits in database
		if (strlen($newProfileNameLast) <= 0) {
			throw new \RangeException("Profile last name too short");
		} else if (strlen($newProfileNameLast) > 50) {
			throw new \RangeException("Profile last name too long");
		}

		$this->profileNameLast = $newProfileNameLast;
	}

	/**
	 * Accessor for profile email
	 * @return string email
	 **/
	public function getProfileEmail() {
		return $this->profileEmail;
	}

	/**
	 * Mutator for profile email
	 * @param string $newProfileEmail, email
	 * @throws \RangeException if profile email is out of bounds
	 * @throws \TypeError if profile email is not a string
	 **/
	public function setProfileEmail(string $newProfileEmail) {
		// Sanitize dat string
		$newProfileEmail = filter_var(trim($newProfileEmail), FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

		// Make sure profile email exists and fits in database
		if (strlen($newProfileEmail) <= 0) {
			throw new \RangeException("Profile email too short");
		} else if (strlen($newProfileEmail) > 75) {
			throw new \RangeException("Profile email too long");
		}

		$this->profileEmail = $newProfileEmail;
	}

	/**
	 * Accessor for profile username
	 * @return string username
	 **/
	public function getProfileUserName() {
		return $this->profileUserName;
	}

	/**
	 * Mutator for profile username
	 * @param string $newProfileUserName, username
	 * @throws \RangeException if profile username is out of bounds
	 * @throws \TypeError if profile username is not a string
	 **/
	public function setProfileUserName(string $newProfileUserName) {
		// Sanitize dat string
		$newProfileUserName = filter_var(trim($newProfileUserName), FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

		// Make sure profile username exists and fits in database
		if (strlen($newProfileUserName) <= 0) {
			throw new \RangeException("Profile username too short");
		} else if (strlen($newProfileUserName) > 25) {
			throw new \RangeException("Profile username too long");
		}

		$this->profileUserName = $newProfileUserName;
	}

    /**
     * accessor method for profile salt
     *
     * @return string value for profile salt
     **/
    public function getProfileSalt() {
        return ($this->profileSalt);
    }

    /**
     * mutator method for profile salt
     *
     * @param string $newProfileSalt new value of user salt
     * @throws \InvalidArgumentException if $newProfileSalt is not a string or insecure
     * @throws \RangeException if $newProfileSalt is > 64 characters
     * @throws \TypeError if $newProfileSalt is not a string
     **/
    public function setProfileSalt($newProfileSalt) {

        if(empty($newProfileSalt)) {
            throw(new \InvalidArgumentException("profile salt is empty or insecure"));
        }

        if(!ctype_xdigit($newProfileSalt)) {
            throw(new \InvalidArgumentException ("user salt is empty or insecure"));
        }

        if(strlen($newProfileSalt) !== 64) {
            throw(new \RangeException("profile salt is not of valid length"));
        }

        $this->profileSalt = $newProfileSalt;
    }


    /**
     * accessor method for profile hash
     *
     * @return string value of profile hash
     **/
    public function getProfileHash() {
        return ($this->profileHash);
    }

    /**
     * mutator method for profile hash
     *
     * @param string $newProfileHash new value of user hash
     * @throws \InvalidArgumentException if $newProfile hash is not a string or insecure
     * @throws \RangeException if $newProfileHash is > 128 characters
     * @throws \TypeError if $newProfileHash is not a string
     **/
    public function setProfileHash($newProfileHash) {
        if(empty($newProfileHash)) {
            throw(new \InvalidArgumentException("profile hash is empty or insecure"));
        }
        if(!ctype_xdigit($newProfileHash)) {
            throw(new \InvalidArgumentException ("user hash is empty or insecure"));
        }
        if(strlen($newProfileHash) !== 128) {
            throw(new \RangeException("profile hash is not of valid length"));
        }
        // store the profile hash
        $this->profileHash = $newProfileHash;
    }

    /**
     * accessor method for profile activation token
     *
     * @return string value of activation token
     **/
    public function getProfileActivationToken() {
        return ($this->profileActivationToken);
    }

    /**
     * mutator method for profile activation token
     *
     * @param string $newProfileActivationToken new value
     * @throws \InvalidArgumentException if $newProfileActivationToken is not a valid email or insecure
     * @throws \RangeException if $newProfileActivationToken is not positive
     * @throws \TypeError if $newProfileActivationToken in not an integer
     **/
    public function setProfileActivationToken(string $newProfileActivationToken = null) {
        if($newProfileActivationToken === null) {
            $this->profileActivationToken = null;
            return;
        }

        // verify the activation token is a hexadecimal
        if(!ctype_xdigit($newProfileActivationToken)) {
            throw(new \InvalidArgumentException ("profile activation is empty or insecure"));
        }

        // verify the activation token is of valid length
        if(strlen($newProfileActivationToken) !== 64) {
            throw(new \RangeException("profile activation token is not of valid length"));
        }
        //convert and store the profile activation token
        $this->profileActivationToken = $newProfileActivationToken;
    }


	/* PDO METHODS */

	public function insert(\PDO $pdo) {
		if ($this->profileId !== null) {
			throw new \PDOException("Cannot insert a profile which already exists.");
		}

		// Create query template
		$query = "INSERT INTO profile(profileAdmin, profileNameFirst, profileNameLast, profileEmail, profileUserName, profileSalt, profileHash, profileActivationToken) VALUES(:profileAdmin, :profileNameFirst, :profileNameLast, :profileEmail, :profileUserName, :profileSalt, :profileHash, :profileActivationToken)";
		$statement = $pdo->prepare($query);

		// Bind member variables to query
		$parameters = ["profileAdmin" => $this->profileAdmin, "profileNameFirst" => $this->profileNameFirst, "profileNameLast" => $this->profileNameLast, "profileEmail" => $this->profileEmail, "profileUserName" => $this->profileUserName, "profileSalt" => $this->profileSalt, "profileHash" => $this->profileHash, "profileActivationToken" => $this->profileActivationToken];
		$statement->execute($parameters);

		// Grab primary key from MySQL
		$this->profileId = intval($pdo->lastInsertId);
	}

	public function delete(\PDO $pdo) {
		if ($this->profileId === null) {
			throw new \PDOException("Cannot delete a profile which doesn't exist.");
		}

		// Create query template
		$query = "DELETE FROM profile WHERE profileId = :profileId";
		$statement = $pdo->prepare($query);

		// Bind member variables to query
		$parameters = ["profileId" => $this->profileId];
		$statement->execute($parameters);
	}

	public function update(\PDO $pdo) {
		if ($this->profileId === null) {
			throw new \PDOException("Cannot update a profile which doesn't exist.");
		}

		// Create query template
		$query = "UPDATE profile SET profileAdmin = :profileAdmin, profileNameFirst = :profileNameFirst, profileNameLast = :profileNameLast, profileEmail = :profileEmail, profileUserName = :profileUserName, profileSalt = :profileSalt, profileHash = :profileHash, profileActivationToken = :profileActivationToken WHERE profileId = :profileId";
		$statement = $pdo->prepare($query);

		// Bind member variables to query
		$parameters = ["profileAdmin" => $this->profileAdmin, "profileNameFirst" => $this->profileNameFirst, "profileNameLast" => $this->profileNameLast, "profileEmail" => $this->profileEmail, "profileUserName" => $this->profileUserName, "profileId" => $this->profileId, "profileSalt" => $this->profileSalt, "profileHash" => $this->profileHash, "profileActivationToken" => $this->profileActivationToken];
		$statement->execute($parameters);
	}

	public static function getProfileByProfileId(\PDO $pdo, int $profileId) {
		if ($profileId <= 0) {
			throw new \PDOException("Not a valid profile ID.");
		}

		// Create query template
		$query = "SELECT profileId, profileAdmin, profileNameFirst, profileNameLast, profileEmail, profileUserName, profileSalt, profileHash, profileActivationToken FROM profile WHERE profileId = :profileId";
		$statement = $pdo->prepare($query);

		// Bind member variables to query
		$parameters = ["profileId" => $profileId];
		$statement->execute($parameters);

		try {
			$profile = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();

			if ($row !== false) {
				$profile = new Profile($row["profileId"], $row["profileAdmin"], $row["profileNameFirst"], $row["profileNameLast"], $row["profileEmail"], $row["profileUserName"], $row["profileSalt"], $row["profileHash"],$row["profileActivationToken"]);
			}
		} catch(\Exception $exception) {
			throw new \PDOException($exception->getMessage(), 0, $exception);
		}

		return $profile;
	}

	public static function getProfileByString(\PDO $pdo, string $attribute, string $search, bool $like = null) {
		$like = $like ? "LIKE" : "="; // Optionally search using "LIKE"
		$attribute = filter_var(trim($attribute), FILTER_SANITIZE_STRING);
		$search = filter_var(trim($search), FILTER_SANITIZE_STRING);

		if (empty($attribute) === true || empty($search) === true) {
			throw new \PDOException("Invalid string.");
		}

		// Create query template
		$query = "SELECT profileId, profileAdmin, profileNameFirst, profileNameLast, profileEmail, profileUserName, profileSalt, profileHash, profileActivationToken FROM profile WHERE :attribute $like :search";
		$statement = $pdo->prepare($query);

		// Bind member variables to query
		$parameters = ["attribute" => $attribute, "search" => $search];
		$statement->execute($parameters);

		// Build an array of matches
		$profiles = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);

		while (($row = $statement->fetch()) !== false) {
			try {
				$profile = new Profile($row["profileId"], $row["profileAdmin"], $row["profileNameFirst"], $row["profileNameLast"], $row["profileEmail"], $row["profileUserName"],$row["profileSalt"],$row["profileHash"], $row["profileActivationToken"]);

				$profiles[$profiles->key()] = $profile;
				$profile->next();
			} catch(\Exception $exception) {
				throw new \PDOException($exception->getMessage(), 0, $exception);
			}
		}
	}

	public static function getAllProfiles(\PDO $pdo) {
		// Create query template and execute
		$query = "SELECT profileId, profileAdmin, profileNameFirst, profileNameLast, profileEmail, profileUserName, profileSalt, profileHash, profileActivationToken FROM profile";
		$statement = $pdo->prepare($query);
		$statement->execute();

		// Build an array of matches
		$profiles = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);

		while (($row = $statement->fetch()) !== false) {
			try {
				$profile = new Profile($row["profileId"], $row["profileAdmin"], $row["profileNameFirst"], $row["profileNameLast"], $row["profileEmail"], $row["profileUserName"], $row["profileSalt"], $row["profileHash"], $row["profileActivationToken"]);

				$profiles[$profiles->key()] = $profile;
				$profiles->next();
			} catch(\Exception $exception) {
				throw new \PDOException($exception->getMessage(), 0, $exception);
			}
		}

		return $profiles;
	}

	/* JSON SERIALIZE */

	public function jsonSerialize() {
		$fields = get_object_vars($this);
		// unset($fields["profileEmailActivation"]);
		unset($fields["profileHash"]);
		unset($fields["profileSalt"]);
		return ($fields);
	}
}
