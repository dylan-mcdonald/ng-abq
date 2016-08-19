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

	// use ValidateDate;

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
	 * @var string $linkDate
	 */
	private $linkDate;

	public function __construct(int $newLinkId = null, int $newLinkProfileId, string $newLinkProfileUserName, string $newLinkUrl, string $newLinkDate) {
		try {
			$this->setLinkId($newLinkId);
			$this->setLinkProfileId($newLinkProfileId);
			$this->setLinkUserName($newLinkProfileUserName);
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

