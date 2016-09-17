<?php

namespace Com\NgAbq\Beta;
require_once("autoload.php");

/**
 * Event class lists when ng events take place
 * @author Eliot Ostling <it.treugott@gmail.com>
 * @version 1.0.0BETA
 **/

class Event implements \JsonSerializable {


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
/*
 *more string
 */
private $eventTime;


    public function __construct(int $newEventId = null, int $newEventProfileId, string $newEventName , string $newEventDate, string $newEventTime)
    {
        try {
            $this->setEventId($newEventId);
            $this->setEventProfileId($newEventProfileId);
            $this->setEventName($newEventName);
            $this->setEventDate($newEventDate);
            $this->setEventTime($newEventTime);
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
    public function setEventId($newEventId = null)
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
    public function setEventProfileId($newEventProfileId = null)
    {
        if($newEventProfileId === null) {
            $this->eventProfileId = null;
            return;
        }


        if($newEventProfileId <= 0) {
            throw(new \RangeException("Ok"));
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
			throw(new \InvalidArgumentException("link profile username is empty or insecure"));
		}

		// verify the link event name will fit in the database
		if(strlen($newEventName) > 25) {
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
    public function setEventDate($newEventDate = null)
    {

        if($newEventDate === null) {
            $this->eventDate = null;
            return;
        }


        if($newEventDate <= 0) {
            throw(new \RangeException("Date is somehow incorrect"));
        }
        //if it works this should happen
        $this->eventDate = $newEventDate;
    }

    public function getEventTime()
    {
        return ($this->eventTime);
    }


    public function setEventTime($newEventTime = null)
    {

        if($newEventTime === null) {
            $this->eventTime = null;
            return;
        }

        if($newEventTime <= 0) {
            throw(new \RangeException("No bueno"));
        }
        //if it's right this should happen
        $this->eventTime = $newEventTime;
    }

    public function insert(\PDO $pdo)
    {

        if($this->eventId !== null) {
            throw(new \PDOException("An event already exists"));
        }
        // create query template
        $query = "INSERT INTO Event(eventProfileId, eventName, eventDate, eventTime) VALUES(:eventProfileId, :eventName, :eventDate, :eventTime)";
        $statement = $pdo->prepare($query);
        // bind the member variables to the place holders in the template
        $parameters = ["eventProfileId" => $this->eventProfileId, "eventName" => $this->eventName, "eventDate" => $this->eventDate, "eventTime" => $this->eventTime];
        $statement->execute($parameters);
        //update the null userId with what mySQL just gave us
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
        $query = "DELETE FROM Event WHERE eventId = :eventId";
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
            throw(new \PDOException("unable to udate an event that does not exist"));
        }
        // create a query template
        $query = "UPDATE Event SET eventProfileId = :eventName, eventDate = :eventTime WHERE eventId = :eventId";
        $statement = $pdo->prepare($query);
        // bind the member variables to the place holders in this template
        $parameters = ["eventProfileId" => $this->eventProfileId, "eventName" => $this->eventName, "eventDate" => $this->eventDate, "eventTime" => $this->eventTime];
        $statement->execute($parameters);
    }


    public static function getEventByEventId(\PDO $pdo, $eventId)
    {
        if($eventId <= 0) {
            throw(new \PDOException("This Event Id is incorrect"));
        }
        $query = "SELECT eventId, eventProfileId, eventName, eventDate, eventTime  FROM Event WHERE eventId = :eventId";
        $statement = $pdo->prepare($query);
        $parameters = array("eventId" => $eventId);
        $statement->execute($parameters);
        try {
            $users = null;
            $statement->setFetchMode(\PDO::FETCH_ASSOC);
            $row = $statement->fetch();
            if($row !== false) {
                $eventId = new Event($row["eventId"], $row["eventProfileId"], $row["eventName"], $row["eventDate"], $row["eventTime"]);
            }
        } catch(\Exception $exception) {
            throw(new \PDOException($exception->getMessage(), 0, $exception));
        }
        return ($eventId);

    }

    public static function getEventByEventProfileId(\PDO $pdo, $eventProfileId )
    {
        $eventProfileId = trim($eventProfileId);
        $eventProfileId = filter_var($eventProfileId, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
        if($eventProfileId<= 0){
            throw (new \PDOException("This is wrong on so many levels"));

        }
        $query = "SELECT eventId, eventProfileId, eventName, eventDate, eventTime  FROM Event WHERE eventProfileId = :eventProfileId";
        $statement = $pdo->prepare($query);
        $parameters = array("eventProfileId" => $eventProfileId);
        $statement->execute($parameters);

        $statement->setFetchMode(\PDO::FETCH_ASSOC);
        try {
            $eventProfileId = null;
            $statement->setFetchMode(\PDO::FETCH_ASSOC);
            $row = $statement->fetch();
            if($row !== false) {
                $eventProfileId = new Event($row["userId"], $row["eventProfileId"], $row["eventName"], $row["eventDate"], $row["eventTime"]);
            }
        } catch
        (\Exception $exception) {
            throw(new \PDOException($exception->getMessage(), 0, $exception));
        }

        return ($eventProfileId);

    }


    public static function getEventByEventDate(\PDO $pdo, $eventDate)
    {
        $eventDate = trim($eventDate);
        $eventDate = filter_var($eventDate, FILTER_SANITIZE_STRING,FILTER_FLAG_NO_ENCODE_QUOTES);
        if($eventDate <=0){
            throw (new \PDOException("Wrong"));
        }

        $query = "SELECT eventId, eventProfileId, eventName, eventDate, eventTime FROM EVENT WHERE eventDate= :eventDate";
        $statement = $pdo->prepare($query);
        $parameters = array("eventDate" => $eventDate);
        $statement->execute($parameters);

        $statement->setFetchMode(\PDO::FETCH_ASSOC);
        try {
            $eventDate = null;
            $statement->setFetchMode(\PDO::FETCH_ASSOC);
            $row = $statement->fetch();
            if($row !== false) {
                $eventDate = new Event($row["userId"], $row["eventProfileId"], $row["eventName"], $row["eventDate"], $row["eventTime"]);
            }
        } catch
        (\Exception $exception) {
            throw(new \PDOException($exception->getMessage(), 0, $exception));
        }

        return ($eventDate);
    }

    public static function getEventByEventTime(\PDO $pdo,$eventTime)
    {
        $eventTime - trim($eventTime);
        if($eventTime <=0){
            throw (new \PDOException("Wrong"));
        }

        $query = "SELECT eventId, eventProfileId, eventName, eventDate, eventTime FROM EVENT WHERE eventTime= :eventTime";
        $statement = $pdo->prepare($query);
        $parameters = array("eventTime" => $eventTime);
        $statement->execute($parameters);

        $statement->setFetchMode(\PDO::FETCH_ASSOC);
        try {
            $eventTime = null;
            $statement->setFetchMode(\PDO::FETCH_ASSOC);
            $row = $statement->fetch();
            if($row !== false) {
                $eventTime = new Event($row["userId"], $row["eventProfileId"], $row["eventName"], $row["eventDate"], $row["eventTime"]);
            }
        } catch
        (\Exception $exception) {
            throw(new \PDOException($exception->getMessage(), 0, $exception));
        }

        return ($eventTime);

    }
    
    
//    public static function getAllEvents(\PDO $pdo)
//    {
//        $query = "SELECT eventId, eventProfileId, eventName, eventDate, eventTime FROM event";
//        $statement = $pdo->prepare($query);
//        $statement->execute();
//
//	    $events = new \SplFixedArray($statement->rowCount());
//	    var_dump($events);
//        $statement->setFetchMode(\PDO::FETCH_ASSOC);
//        while(($row = $statement->fetch()) !== false) {
//            try {
//                $event = new Event($row["eventId"], $row["eventProfileId"], $row["eventName"], $row["eventDate"], $row["eventTime"]);
//                $events[$events->key()] = $event;
//                $events->next();
//            } catch(\Exception $exception) {
//                throw(new \PDOException($exception->getMessage(), 0, $exception));
//            }
//        }
//        return ($events);
//
//    }

	public static function getAllEvents(\PDO $pdo) {
		// create query template
		$query = "SELECT eventId, eventProfileId, eventName, eventDate, eventTime FROM event";
		$statement = $pdo->prepare($query);
		$statement->execute();

		// build an array of events
		$events = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$event = new Event($row["eventId"], $row["eventProfileId"], $row["eventName"], $row["eventDate"], $row["eventTime"]);
				$events[$events->key()] = $event;
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