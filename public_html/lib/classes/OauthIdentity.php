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
class OauthIdentitiy implements \JsonSerializable {

	/* STATE VARIABLES */

	/**
	 * Primary key of oauthIdentity
	 * @var int $oauthIdentityId
	 **/
	private $oauthIdentityId;

	/**
	 * OauthIdentity profile id
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
	 * @param int|null $newOauthIdentityId, primary key, null if new oauthIdentity
	 * @param int $newOauthIdentityProfileId, profile id of authorized access
	 * @param string $newOauthIdentityProviderId, id of provider
	 * @param string $newOauthIdentityProvider, name of provider of authorization
	 * @param string $newOauthIdentityAccessToken, token from provider
	 * @param \DateTime|string|null $newOauthIdentityTimeStamp, time of authorization or null if set to current date and time
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
	 * @param int|null $newOauthIdentityId, primary key
	 * @throws \RangeException if oauthIdentity ID is not > 0
	 * @throws \TypeError if oauthIdentity ID is not an integer
	 **/
	public function setOauthIdentityId(int $newOauthIdentityId = null) {
		// Let oauthIdentity ID = null
		if ($newOauthIdentityId === null) {
			$this->oauthIdentityId = null;
			return;
		}

		// Make sure oauthIdentity ID > 0
		if ($newOauthIdentityId <= 0) {
			throw new \RangeException("OauthIdentity ID must be positive");
		}

		$this->oauthIdentityId = $newOauthIdentityId;
	}



	//TODO
	public function jsonSerialize() {
		// TODO
	}
}
