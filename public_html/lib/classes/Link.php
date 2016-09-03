<?php

namespace Com\NgAbq\Beta;
require_once("autoload.php");

/**
 * Link class for sharing links with others in the ng-abq community.
 *
 * Shares information with the profile class.
 *
 * @author Marlan Ball <wyndows@earthlink.net>
 *
 * @version 1.0.0
 **/
class Link implements \JsonSerializable {

	use ValidateDate;

	/**
	 * id for the link; this is the primary key
	 * @var int $linkId
	 */
	private $linkId;

	/**
	 * foreign key
	 * @var int $linkProfileId
	 */
	private $linkProfileId;

	/**
	 * foreign key
	 * @var string $linkProfileUserName
	 */
	private $linkProfileUserName;

	/**
	 * the url of the shared link
	 * @var string $linkUrl
	 */
	private $linkUrl;

	/**
	 * the date link is shared
	 * @var \DateTime $linkDate
	 */
	private $linkDate;

	public function __construct(int $newLinkId = null, int $newLinkProfileId, string $newLinkProfileUserName, string $newLinkUrl, $newLinkDate = null) {
		try {
			$this->setLinkId($newLinkId);
			$this->setLinkProfileId($newLinkProfileId);
			$this->setLinkProfileUserName($newLinkProfileUserName);
			$this->setLinkUrl($newLinkUrl);
			$this->setLinkDate($newLinkDate);
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
	 * accessor method for link id
	 *
	 * @return int value of link id
	 */
	public function getLinkId() {
		return ($this->linkId);
	}

	/**
	 * mutator method for link id
	 *
	 * @param int|null $newLinkId new value of link id
	 * @throws \RangeException if $newLinkId is not positive
	 * @throws \TypeError if $newLinkId is not an integer
	 */
	public function setLinkId(int $newLinkId = null) {
		// base case: if the link id is null, this is a new link without a mySQL assigned id
		if($newLinkId === null) {
			$this->linkId = null;
			return;
		}

		// verify the link id is positive
		if($newLinkId <= 0) {
			throw(new \RangeException("link id is not positive"));
		}

		// store the link id
		$this->linkId = $newLinkId;

	}

	/**
	 * accessor method for link profile id
	 *
	 * @return int value of link profile id
	 */

	public function getLinkProfileId() {
		return ($this->linkProfileId);
	}

	/**
	 * mutator method for link id
	 *
	 * @param int|null $newLinkProfileId new value of link profile id
	 * @throws \RangeException if $newLinkProfileId is not positive
	 * @throws \TypeError if $newLinkProfileId is not an integer
	 */
	public function setLinkProfileId(int $newLinkProfileId) {
		// verify the linkProfileId is positive
		if($newLinkProfileId <= 0) {
			throw(new \RangeException("linkProfileId is not positive"));
		}

		// convert and store the account id
		$this->linkProfileId = $newLinkProfileId;
	}

	/**
	 * accessor method for link profile username
	 *
	 * @return string value of link profile username
	 */
	public function getLinkProfileUserName() {
		return ($this->linkProfileUserName);
	}

	/**
	 * mutator method for link profile username
	 *
	 * @param string $newLinkProfileUserName new value of link profile username
	 * @throws \InvalidArgumentException if $newLinkProfileUserName is not a string or insecure
	 * @throws \RangeException if $newLinkProfileUserName is > 25 characters
	 * @throws \TypeError if $newLinkProfileUserName is not a string
	 */
	public function setLinkProfileUserName(string $newLinkProfileUserName) {
		// verify the link profile username is secure
		$newLinkProfileUserName = trim($newLinkProfileUserName);
		$newLinkProfileUserName = filter_var($newLinkProfileUserName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newLinkProfileUserName) === true) {
			throw(new \InvalidArgumentException("link profile username is empty or insecure"));
		}

		// verify the link profile username will fit in the database
		if(strlen($newLinkProfileUserName) > 25) {
			throw(new \RangeException("link profile username is too long"));
		}

		// store the product description
		$this->linkProfileUserName = $newLinkProfileUserName;
	}

	/**
	 * accessor method for link url
	 *
	 * @return string value of link url
	 */
	public function getLinkUrl() {
		return ($this->linkUrl);
	}

	/**
	 * mutator method for link url
	 *
	 * @param string $newLinkUrl new value of link url
	 * @throws \InvalidArgumentException if $newLinkUrl is not a string or insecure
	 * @throws \RangeException if $newLinkUrl is > 25 characters
	 * @throws \TypeError if $newLinkUrl is not a string
	 */
	public function setLinkUrl(string $newLinkUrl) {
		// verify the link url is secure
		$newLinkUrl = trim($newLinkUrl);
		$newLinkUrl = filter_var($newLinkUrl, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newLinkUrl) === true) {
			throw(new \InvalidArgumentException("link url is empty or insecure"));
		}

		// verify the link url will fit in the database
		if(strlen($newLinkUrl) > 100) {
			throw(new \RangeException("link url is too long"));
		}

		// store the product description
		$this->linkUrl = $newLinkUrl;
	}

	/**
	 * accessor method for link date
	 *
	 * @return \DateTime value of link date
	 **/
	public function getLinkDate() {
		return ($this->linkDate);
	}

	/**
	 * mutator method for link date
	 *
	 * @param \DateTime|string|null $newLinkDate purchase date as a DateTime object or string (or null to load the current time)
	 * @throws \InvalidArgumentException if $newLinkDate is not a valid object or string
	 * @throws \RangeException if $newLinkDate is  a date that does not exist
	 **/
	public function setLinkDate($newLinkDate = null) {
		// base case: if the date is null, use the current date and time
		if($newLinkDate === null) {
			$this->linkDate = new \DateTime();
			return;
		}

		// store the link date
		try {
			$newLinkDate = $this->validateDate($newLinkDate);
		} catch(\InvalidArgumentException $invalidArgument) {
			throw(new \InvalidArgumentException($invalidArgument->getMessage(), 0, $invalidArgument));
		} catch(\RangeException $range) {
			throw(new \RangeException($range->getMessage(), 0, $range));
		}
		$this->linkDate = $newLinkDate;
	}

// insert
	/**
	 * inserts link information into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 */
	public function insert(\PDO $pdo) {
		// enforce the linkId is null (i.e., don't insert a link that already exists
		if($this->linkId !== null) {
			throw(new \PDOException("not a new link"));
		}

		// create query template
		$query = "INSERT INTO link (linkProfileId, linkProfileUserName, linkUrl, linkDate) VALUES(:linkProfileId, :linkProfileUserName, :linkUrl, :linkDate)";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders in the template
		$formattedDate = $this->linkDate->format("Y-m-d H:i:s");
		$parameters = ["linkProfileId" => $this->linkProfileId, "linkProfileUserName" => $this->linkProfileUserName, "linkUrl" => $this->linkUrl, "linkDate" => $formattedDate];
		$statement->execute($parameters);

		// update the null linkId with what mySQL just gave us
		$this->linkId = intval($pdo->lastInsertId());
	}

	/**
	 * updates this link in mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL errors occure
	 * @throws \TypeError if $pdo is not a PDO connection object
	 */
	public function update(\PDO $pdo) {

		// enforce the linkId is not null (don't update whats not there)
		if($this->linkId === null) {
			throw(new \PDOException("unable to update a link that does not exist"));
		}

		// create query template
		$query = "UPDATE link SET linkProfileId = :linkProfileId, linkProfileUserName = :linkProfileUserName, linkUrl = :linkUrl, linkDate = :linkDate WHERE linkId = :linkId";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders
		$formattedDate = $this->linkDate->format("Y-m-d H:i:s");
		$parameters = ["linkId" => $this->linkId, "linkProfileId" => $this->linkProfileId, "linkProfileUserName" => $this->linkProfileUserName, "linkUrl" => $this->linkUrl, "linkDate" => $formattedDate];
		$statement->execute($parameters);
	}

	/**
	 * deletes this link from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 */
	public function delete(\PDO $pdo) {
		// enforce the linkId is not null (don't delete a link that has just been inserted)
		if($this->linkId === null) {
			throw(new \PDOException("unable to delete a link that does not exist"));
		}

		// create query template
		$query = "DELETE FROM link WHERE linkId = :linkId";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holder in the template
		$parameters = ["linkId" => $this->linkId];
		$statement->execute($parameters);
	}

	/**
	 * gets the link by link id
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param int $linkId - link id to search for
	 * @return link|null - link found or null if not
	 * @throws \PDOException when mySQL related error occurs
	 * @throws \TypeError when variables are not the correct data type
	 */

	public static function getLinkByLinkId(\PDO $pdo, int $linkId) {
		// sanitize the linkId before searching
		if($linkId <= 0) {
			throw(new \PDOException("link id is not positive"));
		}
		// create query template
		$query = "SELECT linkId, linkProfileId, linkProfileUserName, linkUrl, linkDate FROM link WHERE linkId = :linkId";
		$statement = $pdo->prepare($query);

		// bind the link id to the place holder in the template
		$parameters = array("linkId" => $linkId);
		$statement->execute($parameters);

		// grab the link from mySQL
		try {
			$link = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$link = new Link($row["linkId"], $row["linkProfileId"], $row["linkProfileUserName"], $row["linkUrl"], \DateTime::createFromFormat("Y-m-d H:i:s", $row["linkDate"]));
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return ($link);
	}

	// get all links
	/**
	 * gets all links
	 *
	 * @param \PDO $pdo PDO connection object
	 * @return \SplFixedArray SplFixedArray of Links found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getAllLinks(\PDO $pdo) {
		// create query template
		$query = "SELECT linkId, linkProfileId, linkProfileUserName, linkUrl, linkDate FROM link";
		$statement = $pdo->prepare($query);
		$statement->execute();

		// build an array of links
		$links = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$link = new Link($row["linkId"], $row["linkProfileId"], $row["linkProfileUserName"], $row["linkUrl"], \DateTime::createFromFormat("Y-m-d H:i:s", $row["linkDate"]));
				$links[$links->key()] = $link;
				$links->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($links);
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

