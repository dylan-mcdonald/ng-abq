<?php
namespace Com\NgAbq\Beta;
require_once("autoload.php");

/**
 * Image class for sharing images with others in the ng-abq community.
 *
 * Shares information with the profile class.
 *
 * @author Marlan Ball <wyndows@earthlink.net> based on work by Don Deleeuw <donald.deleeuw@gmail.com>
 *
 * @version 1.0.0
 **/

class Image implements \JsonSerializable {

	/**
	 * id for image, this is the primary key
	 * @var int $imageId
	 */
	private $imageId;

	/**
	 * profile id of image uploader
	 * @var string $imageProfileId
	 */
	private $imageProfileId;

	/**
	 * file name of image
	 * @var string $imageFileName
	 */
	private $imageFileName;

	/**
	 * file type of image
	 * @var string $imageType
	 */
	private $imageType;

	/**
	 * constructor for Image class
	 * @param int|null $newImageId - id of this image or null if new image - primary key
	 * @param int $newImageProfileId - id of the uploader of the image
	 * @param string $newImageFileName - string containing name of image file
	 * @param string $newImageType - string containing name of image file type
	 * @throws \InvalidArgumentException - if data types are not valid
	 * @throws \RangeException - if values are out of range (strings too long, negative numbers, etc.)
	 * @throws \TypeError - if data types violate type hints
	 * @throws \Exception - catch all if another error occurs
	 **/
	public function __construct(int $newImageId = null, int $newImageProfileId, string $newImageFileName, string $newImageType) {
		try {
			$this->setImageId($newImageId);
			$this->setImageProfileId($newImageProfileId);
			$this->setImageFileName($newImageFileName);
			$this->setImageType($newImageType);
		} catch(\InvalidArgumentException $invalidArgument) {
			// rethrow the exception to the caller
			throw(new \InvalidArgumentException($invalidArgument->getMessage(), 0, $invalidArgument));
		} catch(\RangeException $range) {
			// rethrow the exception to the caller
			throw (new \RangeException($range->getMessage(), 0, $range));
		} catch(\TypeError $typeError) {
			// rethrow the exception to the caller
			throw(new \TypeError($typeError->getMessage(), 0, $typeError));
		} catch(\Exception $exception) {
			// rethrow the exception to the caller
			throw(new \Exception($exception->getMessage(), 0, $exception));
		}
	}

	/**
	 * accessor method for image id
	 * @return int|null value of image id
	 */
	public function getImageId() {
		return ($this->imageId);
	}

	/**
	 * mutator method for image id
	 * @param int|null $newImageId - new value of image id
	 * @throws \RangeException if $newImageId is not positive
	 * @throws \TypeError if $newimageId is not an intiger
	 **/
	public function setImageId(int $newImageId = null) {
		//if image id is null (composing), allow new image without mySQL assignment
		if($newImageId === null) {
			$this->imageId = null;
			return;
		}
		// verify image id is positive
		if($newImageId <= 0) {
			throw(new \RangeException("image id is not positive"));
		}
		// convert and store image id
		$this->imageId = $newImageId;
	}

	/**
	 * accessor method for image profile id
	 *
	 * @return int value of image profile id
	 */

	public function getImageProfileId() {
		return ($this->imageProfileId);
	}

	/**
	 * mutator method for image profile id
	 *
	 * @param int|null $newImageProfileId new value of image profile id
	 * @throws \RangeException if $newImageProfileId is not positive
	 * @throws \TypeError if $newImageProfileId is not an integer
	 */
	public function setImageProfileId(int $newImageProfileId) {
		// verify the imageProfileId is positive
		if($newImageProfileId <= 0) {
			throw(new \RangeException("imageProfileId is not positive"));
		}

		// convert and store the profile id
		$this->imageProfileId = $newImageProfileId;
	}

	/**
	 * accessor method for image file name
	 *
	 * @return string of image file name
	 */
	public function getImageFileName() {
		return ($this->imageFileName);
	}

	/**
	 * mutator method for image file name
	 * @param string $newImageFileName - new value of image file name
	 * @throws \InvalidArgumentException if $newImageFileName is not a string or insecure
	 * @throws \RangeException if $newImageFileName is > 128 chars
	 * @throws \TypeError if $newImageFileName is not a string
	 */
	public function setImageFileName(string $newImageFileName) {
		// verify image file name is secure
		$newImageFileName = trim($newImageFileName);
		$newImageFileName = filter_var($newImageFileName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newImageFileName) === true) {
			throw(new \InvalidArgumentException("image file name is empty or insecure"));
		}
		// verify the image file name will fit in the database
		if(strlen($newImageFileName) > 128) {
			throw(new \RangeException("image file name too large"));
		}
		// store image file name
		$this->imageFileName = $newImageFileName;
	}

	/**
	 * accessor method for image type
	 * @return string of image type
	 */
	public function getImageType() {
		return ($this->imageType);
	}

	/**
	 * mutator method for image type
	 *
	 * @param string $newImageType - new value of image type
	 * @throws \InvalidArgumentException if $newImageType is not a strgin or insecure
	 * @throws \RangeException if $newImageType is > 10 chars
	 * @throws \TypeError if $newImageType is not a string
	 */
	public function setImageType(string $newImageType) {
		$validTypes = ["image/gif", "image/jpg", "image/jpeg", "image/png"];
		if(in_array($newImageType, $validTypes) === false) {
			throw(new \InvalidArgumentException("image type is not a MIME type"));
		}

		// store image type
		$this->imageType = $newImageType;
	}

	/**
	 * insert this image into mySQL
	 *
	 * @param \PDO $pdo - PDO connection object
	 * @throws \PDOException when mySQL errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 */
	public function insert(\PDO $pdo) {
		// enforce image id is null - make sure inserting new image vs an existing one
		if($this->imageId !== null) {
			throw(new \PDOException("not a new image"));
		}

		//create query table
		$query = "INSERT INTO image(imageProfileId, imageFileName, imageType) VALUES(:imageProfileId, :imageFileName, :imageType)";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders in the template
		$parameters = ["imageProfileId" => $this->imageProfileId, "imageFileName" => $this->imageFileName, "imageType" => $this->imageType];
		$statement->execute($parameters);

		//update the null imageId with what mySQL just gave us
		$this->imageId = intval($pdo->lastInsertId());
	}

	/**
	 * deletes this image from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 */
	public function delete(\PDO $pdo) {
		// enforce the imageId is not null (don't delete an image that has just been inserted)
		if($this->imageId === null) {
			throw(new \PDOException("unable to delete an image that does not exist"));
		}

		// create query template
		$query = "DELETE FROM image WHERE imageId = :imageId";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holder in the template
		$parameters = ["imageId" => $this->imageId];
		$statement->execute($parameters);
	}

	/**
	 * gets the image by image id
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param int $imageId - image id to search for
	 * @return Image|null - image found or null if not
	 * @throws \PDOException when mySQL related error occurs
	 * @throws \TypeError when variables are not the correct data type
	 */

	public static function getImageByImageId(\PDO $pdo, int $imageId) {
		// sanitize the imageId before searching
		if($imageId <= 0) {
			throw(new \PDOException("image id is not positive"));
		}
		// create query template
		$query = "SELECT imageId, imageProfileId, imageFileName, imageType FROM image WHERE imageId = :imageId";
		$statement = $pdo->prepare($query);

		// bind the image id to the place holder in the template
		$parameters = array("imageId" => $imageId);
		$statement->execute($parameters);

		// grab the image from mySQL
		try {
			$image = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$image = new Image($row["imageId"], $row["imageProfileId"], $row["imageFileName"], $row["imageType"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return ($image);
	}


	/**
	 * gets the image by file name
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string $imageFileName - file name of image
	 * @return Image|null - image found or null if not
	 * @throws \PDOException when mySQL related error occurs
	 * @throws \TypeError when variables are not the correct data type
	 */

	public static function getImageByImageFileName(\PDO $pdo, string $imageFileName) {
// sanitize the image file name before searching
		$imageFileName = trim($imageFileName);
		$imageFileName = filter_var($imageFileName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($imageFileName) === true) {
			throw(new \PDOException("image file name content is invalid"));
		}
		// create query template
		$query = "SELECT imageId, imageProfileId, imageFileName, imageType FROM image WHERE imageFileName LIKE :imageFileName";
		$statement = $pdo->prepare($query);

		// bind the image file name to the place holder in the template
		$imageFileName = "%$imageFileName%";
		$parameters = array("imageFileName" => $imageFileName);
		$statement->execute($parameters);

		// build an array of images
		$images = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$image = new Image($row["imageId"], $row["imageProfileId"], $row["imageFileName"], $row["imageType"]);
				$images[$images->key()] = $image;
				$images->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($images);
	}

	/**
	 * getAllImages
	 *
	 * @param \PDO $pdo PDO connection object
	 * @return \SplFixedArray SplFixedArray of images found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getAllImages(\PDO $pdo) {
		// create query template
		$query = "SELECT imageId, imageProfileId, imageFileName, imageType FROM image";
		$statement = $pdo->prepare($query);
		$statement->execute();

		// build an array of images
		$images = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$image = new Image($row["imageId"], $row["imageProfileId"], $row["imageFileName"], $row["imageType"]);
				$images[$images->key()] = $image;
				$images->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($images);
	}


	/**
	 * formats the state variables for JSON serialization
	 *
	 * @return array resulting state variables to serialize
	 */
	public function jsonSerialize() {
		$fields = get_object_vars($this);
		return($fields);
	}

}













