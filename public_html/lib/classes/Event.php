<?php

namespace Com\NgAbq\Beta;
require_once("autoload.php");

/**
 * Event class lists when ng events take place
 * @author Eliot Ostling <it.treugott@gmail.com>
 * @version 1.0.0BETA
 **/

class Event implements \JsonSerializable {
use ValidateDate;

/*
 * Primary Key
 */
private $eventId;
/*
 * Foreign Key
 */
private $eventProfileId;
/*
 *string
 */
private $eventName;
/*
 *string
 */
private $eventDate;



    public function __construct(int $newEventId = null, int $newEventProfileId, string $newEventName , $newEventDate = null)
    {
        try {
        	echo 'help me more';
            $this->setEventId($newEventId);
            $this->setEventProfileId($newEventProfileId);
            $this->setEventName($newEventName);
            $this->setEventDate($newEventDate);

            } catch(\InvalidArgumentException $invalidArgument) {
            //rethrow the exception to the caller
            throw(new \InvalidArgumentException($invalidArgument->getMessage(), 0, $invalidArgument));
        } catch(\RangeException $range) {
            // rethrow the exception to the caller
            throw(new \RangeException($range->getMessage(), 0, $range));
        } catch(\TypeError $typeError) {
            //rethrow the exception to the caller
            throw(new \TypeError($typeError->getMessage(), 0, $typeError));
        } catch(\Exception $exception) {
            // rethrow the exception to the caller
            throw(new \Exception($exception->getMessage(), 0, $exception));
        }
    }


    public function getEventId()
    {
        return ($this->eventId);
    }

    /**
     * mutator method
     *
     **/
    public function setEventId(int $newEventId = null)
    {
        if($newEventId === null) {
            $this->eventId = null;
            return;
        }

        if($newEventId <= 0) {
            throw(new \RangeException("Ok"));
        }
        //convert and store the event id
        $this->eventId = $newEventId;

    }

//accessor
    public function getEventProfileId()
    {
        return ($this->eventProfileId);
    }
//mutator
    public function setEventProfileId(int $newEventProfileId)
    {
        if($newEventProfileId <= 0) {
            throw(new \RangeException("not Ok"));
        }

        $this->eventProfileId = $newEventProfileId;

    }

    //accessor
    public function getEventName()
    {
        return ($this->eventName);
    }

    //mutator
	public function setEventName(string $newEventName) {
		// verify the link profile username is secure
		$newEventName = trim($newEventName);
		$newEventName = filter_var($newEventName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newEventName) === true) {
			throw(new \InvalidArgumentException("event name is empty or insecure"));
		}

		// verify the link event name will fit in the database
		if(strlen($newEventName) > 50) {
			throw(new \RangeException("link profile username is too long"));
		}

		// store the event name
		$this->eventName = $newEventName;

	}
//accessor
    public function getEventDate()
    {
        return ($this->eventDate);
    }

    //Mutator
	public function setEventDate($newEventDate = null) {
		// base case: if the date is null, use the current date and time
		if($newEventDate === null) {
			$this->eventDate = new \DateTime();
			return;
		}

		// store the event date
		try {
			$newEventDate = $this->validateDate($newEventDate);
		} catch(\InvalidArgumentException $invalidArgument) {
			throw(new \InvalidArgumentException($invalidArgument->getMessage(), 0, $invalidArgument));
		} catch(\RangeException $range) {
			throw(new \RangeException($range->getMessage(), 0, $range));
		}
		$this->eventDate = $newEventDate;
		echo 'eventProfileId';
	}



    public function insert(\PDO $pdo)
    {

        if($this->eventId !== null) {
            throw(new \PDOException("An event already exists"));
        }
        // create query template
        $query = "INSERT INTO Event(eventProfileId, eventName, eventDate) VALUES(:eventProfileId, :eventName, :eventDate)";
        $statement = $pdo->prepare($query);

	    // bind the member variables to the place holders in the template
	    $formattedDate = $this->linkDate->format("Y-m-d H:i:s");
        $parameters = ["eventProfileId" => $this->eventProfileId, "eventName" => $this->eventName, "eventDate" => $formattedDate];
        $statement->execute($parameters);

	    //update the null eventId with what mySQL just gave us
        $this->eventId = intval($pdo->lastInsertId());
    }

    /**
     *deletes this User from mySQL
     *
     * @param \PDO $pdo PDO connection object
     * @throws \PDOException when mySQL related errors occur
     * @throws \TypeError if $pdo is not a PDO connection object
     * **/
    public function delete(\PDO $pdo)
    {
        //enforce the userId is not null
        if($this->eventId === null) {
            throw(new \PDOException("unable to delete an event that does not exist"));
        }
        // create a query template
        $query = "DELETE FROM event WHERE eventId = :eventId";
        $statement = $pdo->prepare($query);
        //bind the member variables to the place holder in the template
        $parameters = ["eventId" => $this->eventId];
        $statement->execute($parameters);
    }

    /**
     * updates this User in mySQL
     *
     * @param \PDO $pdo PDO connection object
     * @throws \PDOException when mySQL related errors occur
     * @throws \TypeError if $pdo is not a PDO connection object
     **/
    public function update(\PDO $pdo)
    {
        // enforce the userId is not null
        if($this->eventId === null) {
            throw(new \PDOException("unable to update an event that does not exist"));
        }
        // create a query template
        $query = "UPDATE event SET eventProfileId = :eventProfileId, eventName = :eventName, eventDate = :eventDate WHERE eventId = :eventId";
        $statement = $pdo->prepare($query);

	    // bind the member variables to the place holders in this template
	    $formattedDate = $this->linkDate->format("Y-m-d H:i:s");
        $parameters = ["eventProfileId" => $this->eventProfileId, "eventName" => $this->eventName, "eventDate" => $formattedDate];
        $statement->execute($parameters);
    }


    public static function getEventByEventId(\PDO $pdo, $eventId)
    {
        if($eventId <= 0) {
            throw(new \PDOException("This Event Id is incorrect"));
        }
        $query = "SELECT eventId, eventProfileId, eventName, eventDate  FROM event WHERE eventId = :eventId";
        $statement = $pdo->prepare($query);
        $parameters = array("eventId" => $eventId);
        $statement->execute($parameters);
        try {
            $event = null;
            $statement->setFetchMode(\PDO::FETCH_ASSOC);
            $row = $statement->fetch();
            if($row !== false) {
                $event = new event($row["eventId"], $row["eventProfileId"], $row["eventName"], $row["eventDate"]);
            }
        } catch(\Exception $exception) {
            throw(new \PDOException($exception->getMessage(), 0, $exception));
        }
        return ($event);

    }

    public static function getEventByEventProfileId(\PDO $pdo, $eventProfileId )
    {
        if($eventProfileId<= 0){
            throw (new \PDOException("This is wrong on so many levels"));
        }

        $query = "SELECT eventId, eventProfileId, eventName, eventDate  FROM event WHERE eventProfileId = :eventProfileId";
        $statement = $pdo->prepare($query);
        $parameters = array("eventProfileId" => $eventProfileId);
        $statement->execute($parameters);

	    // build an array of events
	    $events = new \SplFixedArray($statement->rowCount());
	    $statement->setFetchMode(\PDO::FETCH_ASSOC);
	    while(($row = $statement->fetch()) !== false) {
		    try {
			    $event = new Event($row["eventId"], $row["eventProfileId"], $row["eventName"], \DateTime::createFromFormat("Y-m-d H:i:s", $row["eventDate"]));
			    $events[$events->key()] = $event;
			    $events->next();
		    } catch(\Exception $exception) {
			    // if the row couldn't be converted, rethrow it
			    throw(new \PDOException($exception->getMessage(), 0, $exception));
		    }
	    }
	    return ($events);

    }


	public static function getEventbyEventDate(\PDO $pdo, \DateTime $eventDate) {
		try {
			$eventDate = self::validateDateTime($eventDate);
		} catch(\Exception $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}

		// Create query template
		$query = "SELECT eventId, eventProfileId, eventName, eventDate FROM event WHERE eventDate = :eventDate";
		$statement = $pdo->prepare($query);

		// Bind member variables to query
		$parameters = ["eventDate" => $eventDate->format("Y-m-d H:i:s")];
		$statement->execute($parameters);

		// Build an array of matches
		$events = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);

		while (($row = $statement->fetch()) !== false) {
			try {
				$event = new Event($row["eventId"], $row["eventProfileId"], $row["eventName"], DateTime::createFromFormat("Y-m-d H:i:s", $row["eventDate"]));

				$events[$events->key()] = $event;
				$event->next();
			} catch(\Exception $exception) {
				throw new \PDOException($exception->getMessage(), 0, $exception);
			}
		}

		return $events;
	}


	public static function getAllEvents(\PDO $pdo) {
		// create query template
		$query = "SELECT eventId, eventProfileId, eventName, eventDate FROM event";

		$statement = $pdo->prepare($query);

		$statement->execute();

		// build an array of events
		$events = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			echo 'row';
			var_dump($row);
			try {
				echo 'help';
				$event = new Event($row["eventId"], $row["eventProfileId"], $row["eventName"], \DateTime::createFromFormat("Y-m-d H:i:s", $row["eventDate"]));
				echo 'event';
				var_dump($event);
				$events[$events->key()] = $event;
				echo 'events';
				var_dump($events);
				$events->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($events);
	}

    public function jsonSerialize() {
        $fields = get_object_vars($this);
        return ($fields);
    }





}
