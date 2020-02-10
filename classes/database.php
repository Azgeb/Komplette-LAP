<?php

require_once('../classes/user.php');
require_once('../classes/event.php');

class Database
{

    // Private variable that can only be called inside the class and it's child objects 
    private $database;

    // The constructor gets called when the class gets created 
    public function __construct($host, $dbname, $user, $password)
    {
        $this->database = new PDO('mysql:host=' . $host . ';dbname=' . $dbname, $user, $password);
        $this->database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    }

    // Database-Getter 
    public function getDatabase()
    {
        return $this->database;
    }

    // Performs a query on the database
    public function query($query)
    {
        return $this->database->query($query);
    }

    // Create a new user
    public function createUser($email, $password, $userRole)
    {

        // Prepares the db-statement 
        $statement = $this->database->prepare("INSERT INTO `t_user` (`email`, `password`,`user_role`) VALUES (:email,:password,:userRole)");
        $statement->bindParam(':email', $email);
        $statement->bindParam(':password', password_hash($password, PASSWORD_DEFAULT));
        $statement->bindParam(':userRole', $userRole);

        // Executes the  query and returns the result
        return $statement->execute();
    }

    // Delete an User by id
    public function deleteUser($id)
    {
        $query = 'UPDATE `user` SET `active` = 0 WEHRE `id` = ' . $id;
        return $this->query($query);
    }

    // Updates an user by an new user object
    public function updateUser($user)
    {
        // Prepare db-statements
        $statement = $this->database->prepare("UPDATE t_user SET firstname = :firstname , lastname = :lastname  WHERE id = :id");
        $statement->bindParam(':id', $user->id);
        $statement->bindParam(':firstname', $user->firstname);
        $statement->bindParam(':lastname', $user->lastname);

        // Execute query and return
        return $statement->execute();
    }

    // Gets an User by the email
    public function getUser($email)
    {

        $statement = $this->database->prepare("SELECT * FROM t_user WHERE email = :email");
        $statement->execute(array('email' => $email));
        $sqlResult = $statement->fetch();

        $user = new User();
        $user->id = $sqlResult['id'];
        $user->email = $sqlResult['email'];
        $user->password = $sqlResult['password'];
        $user->firstname = $sqlResult['firstname'];
        $user->lastname = $sqlResult['lastname'];
        $user->userRole = $sqlResult['user_role'];

        return $user;
    }

    public function createEvent($event)
    {

        // Prepares the db-statement 
        $statement = $this->database->prepare("INSERT INTO `t_event` (`heading`, `description`, `event_date`) VALUES (:heading, :description, :eventDate)");
        $statement->bindParam(':heading', $event->heading);
        $statement->bindParam(':description', $event->description);
        $statement->bindParam(':eventDate', $event->eventDate);

        // Executes the  query and returns the result
        return $statement->execute();
    }

    public function getEvents()
    {

        $statement = $this->database->prepare("SELECT * FROM t_event");
        $statement->execute();
        $sqlResult = $statement->fetchAll();

        $events =array();
       

        foreach ($sqlResult as &$SqlEvent) {
            $event = new Event();
            $event->id = $SqlEvent['id'];
            $event->heading = $SqlEvent['heading'];
            $event->description = $SqlEvent['description'];
            $event->eventDate = $SqlEvent['event_date'];
            array_push($events, $event);
        }
        return $events;
    }

    public function joinEvent($eventId, $userId)
    {

        // Prepares the db-statement 
        $statement = $this->database->prepare("INSERT INTO `t_event_user` (`event_id`, `user_id`) VALUES (:eventId,:userId)");
        $statement->bindParam(':eventId', $eventId);
        $statement->bindParam(':userId', $userId);

        // Executes the  query and returns the result
        return $statement->execute();
    }

    public function isUserJoinedEvent($eventId, $userId)
    {

        // Prepares the db-statement 
        $statement = $this->database->prepare("SELECT * FROM `t_event_user` WHERE event_id = :eventId AND user_id = :userId");
        $statement->execute(array('eventId' => $eventId, 'userId' => $userId));
        $result = $statement->fetchAll();

        if (count($result) > 0) {
            return true;
        } else {
            return false;
        }
        // Executes the  query and returns the result

    }
    // Determines if a user login attempt succeeds or fails
    public function login($email, $password)
    {
        $user = $this->getUser($email);
        echo '<script>';
        echo 'console.log(' . json_encode($user) . ')';
        echo '</script>';
        if ($user) {
            if (password_verify($password, $user->password)) {
                echo '<script>';
                echo 'console.log(' . json_encode($user) . ')';
                echo '</script>';
                return $user;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}
