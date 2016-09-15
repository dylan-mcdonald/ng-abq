<?php

namespace Com\NgAbq\Beta;
require_once("autoload.php");

/**
 * PHP representation of an OAuth identity.
 *
 * The OAuth identity is information about where a user logged in from.
 *
 * @author Skyler Rexroad <skyler.rexroad@gmail.com> and Marlan Ball <wyndows@earthlink.net>
 *
 * @version 1.0.0
 **/
class OauthIdentity implements \JsonSerializable {

	/* STATE VARIABLES */

	/**
	 * Primary key of oauthIdentity
	 * @var int $oauthIdentityId
	 **/
	private $oauthIdentityId;

	/**
	 * OauthIdentity oauthIdentity id
	 * @var int $oauthIdentityProfileId
	 **/
	private $oauthIdentityProfileId;

	/**
	 * OauthIdentity provider id
	 * @var string $oauthIdentityProviderId
	 **/
	private $oauthIdentityProviderId;

	/**
	 * OauthIdentity provider
	 * @var string $oauthIdentityProvider
	 **/
	private $oauthIdentityProvider;

	/**
	 * OauthIdentityAccessToken
	 * @var string $oauthIdentityAccessToken
	 **/
	private $oauthIdentityAccessToken;

	/**
	 * OauthIdentity time stamp
	 * @var \DateTime $oauthIdentityTimeStamp
	 **/
	private $oauthIdentityTimeStamp;

	/* CONSTRUCTOR */

	/**
	 * Constructor for oauthIdentity
	 *
	 * @param int|null $newOauthIdentityId , primary key, null if new oauthIdentity
	 * @param int $newOauthIdentityProfileId , oauthIdentity id of authorized access
	 * @param string $newOauthIdentityProviderId , id of provider
	 * @param string $newOauthIdentityProvider , name of provider of authorization
	 * @param string $newOauthIdentityAccessToken , token from provider
	 * @param \DateTime|string|null $newOauthIdentityTimeStamp , time of authorization or null if set to current date and time
	 * @throws \InvalidArgumentException if argument does not cooperate
	 * @throws \RangeException if argument is out of bounds
	 * @throws \TypeError if type is invalid
	 * @throws \Exception to handle edge cases
	 **/
	public function __construct(int $newOauthIdentityId = null, int $newOauthIdentityProfileId, string $newOauthIdentityProviderId, string $newOauthIdentityProvider, string $newOauthIdentityAccessToken, $newOauthIdentityTimeStamp = null) {
		try {
			$this->setOauthIdentityId($newOauthIdentityId);
			$this->setOauthIdentityProfileId($newOauthIdentityProfileId);
			$this->setOauthIdentityProviderId($newOauthIdentityProviderId);
			$this->setOauthIdentityProvider($newOauthIdentityProvider);
			$this->setOauthIdentityAccessToken($newOauthIdentityAccessToken);
			$this->setOauthIdentityTimeStam($newOauthIdentityTimeStamp);
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
	 * Accessor for oauthIdentity ID
	 * @return int|null primary key
	 **/
	public function getoauthIdentityId() {
		return $this->oauthIdentityId;
	}

	/**
	 * Mutator for oauthIdentity ID
	 * @param int|null $newOauthIdentityId , primary key
	 * @throws \RangeException if oauthIdentity ID is not > 0
	 * @throws \TypeError if oauthIdentity ID is not an integer
	 **/
	public function setOauthIdentityId(int $newOauthIdentityId = null) {
		// Let oauthIdentity ID = null
		if($newOauthIdentityId === null) {
			$this->oauthIdentityId = null;
			return;
		}

		// Make sure oauthIdentity ID > 0
		if($newOauthIdentityId <= 0) {
			throw new \RangeException("OauthIdentity ID must be positive");
		}

		$this->oauthIdentityId = $newOauthIdentityId;
	}

	/**
	 * accessor method for oauthIdentity oauthIdentity id
	 *
	 * @return int value of oauthIdentity oauthIdentity id
	 */

	public function getOauthIdentityProfileId() {
		return ($this->oauthIdentityProfileId);
	}

	/**
	 * mutator method for oauthIdentity oauthIdentity id
	 *
	 * @param int|null $newOauthIdentityProfileId new value of oauthIdentity oauthIdentity id
	 * @throws \RangeException if $newOauthIdentityProfileId is not positive
	 * @throws \TypeError if $newOauthIdentityProfileId is not an integer
	 */
	public function setOauthIdentityProfileId(int $newOauthIdentityProfileId) {
		// verify the oauthIdentityProfileId is positive
		if($newOauthIdentityProfileId <= 0) {
			throw(new \RangeException("oauthIdentityProfileId is not positive"));
		}

		// convert and store oauthIdentity oauthIdentity id
		$this->oauthIdentityProfileId = $newOauthIdentityProfileId;
	}

	/**
	 * accessor method for oauthIdentity provider id
	 *
	 * @return string value of oauthIdentity provider id
	 */
	public function getOauthIdentityProviderId() {
		return ($this->oauthIdentityProviderId);
	}

	/**
	 * mutator method for oauthIdentity provider id
	 *
	 * @param string $newOauthIdentityProviderId new value of oauthIdentity provider id
	 * @throws \InvalidArgumentException if $newOauthIdentityProviderId is not a string or insecure
	 * @throws \RangeException if $newOauthIdentityProviderId is > 28 characters
	 * @throws \TypeError if $newOauthIdentityProviderId is not a string
	 */
	public function setOauthIdentityProviderId(string $newOauthIdentityProviderId) {
		// verify the oauthIdentity provider id is secure
		$newOauthIdentityProviderId = trim($newOauthIdentityProviderId);
		$newOauthIdentityProviderId = filter_var($newOauthIdentityProviderId, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newOauthIdentityProviderId) === true) {
			throw(new \InvalidArgumentException("oauthIdentity provider id is empty or insecure"));
		}

		// verify the oauthIdentity provider id will fit in the database
		if(strlen($newOauthIdentityProviderId) > 28) {
			throw(new \RangeException("oauthIdentity provider id is too long"));
		}

		// store the oauthIdentity provider id
		$this->oauthIdentityProviderId = $newOauthIdentityProviderId;
	}

	/**
	 * accessor method for oauthIdentity provider
	 *
	 * @return string value of oauthIdentity provider
	 */
	public function getOauthIdentityProvider() {
		return ($this->oauthIdentityProvider);
	}

	/**
	 * mutator method for oauthIdentity provider
	 *
	 * @param string $newOauthIdentityProvider new value of oauthIdentity provider
	 * @throws \InvalidArgumentException if $newOauthIdentityProvider is not a string or insecure
	 * @throws \RangeException if $newOauthIdentityProvider is > 28 characters
	 * @throws \TypeError if $newOauthIdentityProvider is not a string
	 */
	public function setOauthIdentityProvider(string $newOauthIdentityProvider) {
		// verify the oauthIdentity provider is secure
		$newOauthIdentityProvider = trim($newOauthIdentityProvider);
		$newOauthIdentityProvider = filter_var($newOauthIdentityProvider, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newOauthIdentityProvider) === true) {
			throw(new \InvalidArgumentException("oauthIdentity provider is empty or insecure"));
		}

		// verify the oauthIdentity provider will fit in the database
		if(strlen($newOauthIdentityProvider) > 28) {
			throw(new \RangeException("oauthIdentity provider is too long"));
		}

		// store the oauthIdentity provider
		$this->oauthIdentityProvider = $newOauthIdentityProvider;
	}

	/**
	 * accessor method for oauthIdentity accessToken
	 *
	 * @return string value of oauthIdentity accessToken
	 */
	public function getOauthIdentityAccessToken() {
		return ($this->oauthIdentityAccessToken);
	}

	/**
	 * mutator method for oauthIdentity accessToken
	 *
	 * @param string $newOauthIdentityAccessToken new value of oauthIdentity accessToken
	 * @throws \InvalidArgumentException if $newOauthIdentityAccessToken is not a string or insecure
	 * @throws \RangeException if $newOauthIdentityAccessToken is > 28 characters
	 * @throws \TypeError if $newOauthIdentityAccessToken is not a string
	 */
	public function setOauthIdentityAccessToken(string $newOauthIdentityAccessToken) {
		// verify the oauthIdentity accessToken is secure
		$newOauthIdentityAccessToken = trim($newOauthIdentityAccessToken);
		$newOauthIdentityAccessToken = filter_var($newOauthIdentityAccessToken, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newOauthIdentityAccessToken) === true) {
			throw(new \InvalidArgumentException("oauthIdentity accessToken is empty or insecure"));
		}

		// verify the oauthIdentity accessToken will fit in the database
		if(strlen($newOauthIdentityAccessToken) > 28) {
			throw(new \RangeException("oauthIdentity accessToken is too long"));
		}

		// store the oauthIdentity accessToken
		$this->oauthIdentityAccessToken = $newOauthIdentityAccessToken;
	}

	/**
	 * accessor method for oauthIdentity timeStamp
	 *
	 * @return \DateTime value of oauthIdentity timeStamp
	 **/
	public function getOauthIdentityTimeStamp() {
		return ($this->oauthIdentityTimeStamp);
	}

	/**
	 * mutator method for oauthIdentity timeStamp
	 *
	 * @param \DateTime|string|null $newOauthIdentityTimeStamp purchase timeStamp as a DateTime object or string (or null to load the current timeStamp)
	 * @throws \InvalidArgumentException if $newOauthIdentityTimeStamp is not a valid object or string
	 * @throws \RangeException if $newOauthIdentityTimeStamp is  a timeStamp that does not exist
	 **/
	public function setOauthIdentityTimeStamp($newOauthIdentityTimeStamp = null) {
		// base case: if the time is null, use the current date and time
		if($newOauthIdentityTimeStamp === null) {
			$this->oauthIdentityTimeStamp = new \DateTime();
			return;
		}

		// store the oauthIdentity timeStamp
		try {
			$newOauthIdentityTimeStamp = $this->validateDate($newOauthIdentityTimeStamp);
		} catch(\InvalidArgumentException $invalidArgument) {
			throw(new \InvalidArgumentException($invalidArgument->getMessage(), 0, $invalidArgument));
		} catch(\RangeException $range) {
			throw(new \RangeException($range->getMessage(), 0, $range));
		}
		$this->oauthIdentityTimeStamp = $newOauthIdentityTimeStamp;
	}

	/* PDO METHODS */

	public static function getOauthIdentityByOauthIdentityId(\PDO $pdo, int $oauthIdentityId) {
		if ($oauthIdentityId <= 0) {
			throw new \PDOException("Not a valid OAuth identity ID.");
		}

		// Create query template
		$query = "SELECT oauthIdentityId, oauthIdentityProfileId, oauthIdentityProviderId, oauthIdentityProvider, oauthIdentityAccessToken, oauthIdentityTimeStamp FROM oauthIdentity WHERE oauthIdentityId = :oauthIdentityId";
		$statement = $pdo->prepare($query);

		// Bind member variables to query
		$parameters = ["oauthIdentityId" => $oauthIdentityId];
		$statement->execute($parameters);

		try {
			$oauthIdentity = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();

			if ($row !== false) {
				$oauthIdentity = new OauthIdentity($row["oauthIdentityId"], $row["oauthIdentityProfileId"], $row["oauthIdentityProviderId"], $row["oauthIdentityProvider"], $row["oauthIdentityAccessToken"], $row["oauthIdentityTimeStamp"]);
			}
		} catch(\Exception $exception) {
			throw new \PDOException($exception->getMessage(), 0, $exception);
		}

		return $oauthIdentity;
	}

	public static function getOauthIdentityByOauthIdentityProfileId(\PDO $pdo, int $oauthIdentityProfileId) {
		if ($oauthIdentityProfileId <= 0) {
			throw new \PDOException("Not a valid OAuth identity ID.");
		}

		// Create query template
		$query = "SELECT oauthIdentityId, oauthIdentityProfileId, oauthIdentityProviderId, oauthIdentityProvider, oauthIdentityAccessToken, oauthIdentityTimeStamp FROM oauthIdentity WHERE oauthIdentityProfileId = :oauthIdentityProfileId";
		$statement = $pdo->prepare($query);

		// Bind member variables to query
		$parameters = ["oauthIdentityProfileId" => $oauthIdentityProfileId];
		$statement->execute($parameters);

		try {
			$oauthIdentity = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();

			if ($row !== false) {
				$oauthIdentity = new OauthIdentity($row["oauthIdentityId"], $row["oauthIdentityProfileId"], $row["oauthIdentityProviderId"], $row["oauthIdentityProvider"], $row["oauthIdentityAccessToken"], $row["oauthIdentityTimeStamp"]);
			}
		} catch(\Exception $exception) {
			throw new \PDOException($exception->getMessage(), 0, $exception);
		}

		return $oauthIdentity;
	}

	public static function getOauthIdentityByString(\PDO $pdo, string $attribute, string $search, bool $like = null) {
		$like = $like ? "LIKE" : "="; // Optionally search using "LIKE"
		$attribute = filter_var(trim($attribute), FILTER_SANITIZE_STRING);
		$search = filter_var(trim($search), FILTER_SANITIZE_STRING);

		if (empty($attribute) === true || empty($search) === true) {
			throw new \PDOException("Invalid string.");
		}

		// Create query template
		$query = "SELECT oauthIdentityId, oauthIdentityProfileId, oauthIdentityProviderId, oauthIdentityProvider, oauthIdentityAccessToken, oauthIdentityTimeStamp FROM oauthIdentity WHERE :attribute $like :search";
		$statement = $pdo->prepare($query);

		// Bind member variables to query
		$parameters = ["attribute" => $attribute, "search" => $search];
		$statement->execute($parameters);

		// Build an array of matches
		$oauthIdentities = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);

		while (($row = $statement->fetch()) !== false) {
			try {
				$oauthIdentity = new OauthIdentity($row["oauthIdentityId"], $row["oauthIdentityProfileId"], $row["oauthIdentityProviderId"], $row["oauthIdentityProvider"], $row["oauthIdentityAccessToken"], $row["oauthIdentityTimeStamp"]);

				$oauthIdentities[$oauthIdentities->key()] = $oauthIdentity;
				$oauthIdentity->next();
			} catch(\Exception $exception) {
				throw new \PDOException($exception->getMessage(), 0, $exception);
			}
		}
	}

	/* JSON SERIALIZE */

	public function jsonSerialize() {
		$fields = get_object_vars($this);
		return ($fields);
	}
}
