<?php

require_once('../classes/user.php');
require_once('../classes/event.php');

class Database
{

    // Private variable that can only be called inside the class and it's child objects 
    private $database;
    private $mysqli;

    // The constructor gets called when the class gets created 
    public function __construct($host, $dbname, $user, $password){
        // Opens the database connection with the variables from the config.php
        $this->mysqli = new mysqli($host, $user, $password, $dbname);
        if ($this->mysqli->connect_errno) {
            echo "Failed to connect to MySQL: " . $this->mysqli->connect_error;
        }
    }

    // Database-Getter 
    public function getDatabase(){
        return $this->database;
    }

    // Performs a query on the database
    public function query($query){
        return $this->database->query($query);
    }

    // Create a new user
    public function createUser($user){

        // hash th password 
        $hashedPassword = password_hash($user->password, PASSWORD_DEFAULT);
        // Prepares the db-statement 
        $statement = "INSERT INTO `t_user` (`email`, `password`,`user_role`) VALUES ('$user->email','$hashedPassword','$user->userRole')";

        // Executes the  query and returns the result
        return  $this->mysqli->query($statement);
    }

    // Delete an User by id
    /*
    public function deleteUser($id){
        $query = 'UPDATE `t_user` SET `active` = 0 WEHRE `id` = ' . $id;
        return $this->query($query);
    }
    */

    // Updates an user by an new user object
    public function updateUser($user){
        
        // Prepare db-statements
        $statement = "UPDATE t_user SET firstname = '$user->firstname' , lastname = '$user->lastname'  WHERE id = '$user->id'";

        // Execute query and return
        return  $this->mysqli->query($statement);
    }

    // Gets an user by the email
    public function getUser($email){
        
        // Prepare db-statements
        $statement = "SELECT * FROM t_user WHERE email = '$email';";
        $result = mysqli_query($this->mysqli,$statement);

        // Associative array
        $sqlResult = mysqli_fetch_array($result, MYSQLI_ASSOC);

        // Creates the user from the returned row if one is returned
        if (count($sqlResult) > 0) {
            $user = new User();
            $user->id = $sqlResult['id'];
            $user->email = $sqlResult['email'];
            $user->password = $sqlResult['password'];
            $user->firstname = $sqlResult['firstname'];
            $user->lastname = $sqlResult['lastname'];
            $user->userRole = $sqlResult['user_role'];
        }
        // Returns the user
        return $user;
    }

    // Creates a new event 
    public function createEvent($event){

        // Prepares the db-statement 
        $statement = "INSERT INTO `t_event` (`heading`, `description`, `event_date`) VALUES ('$event->heading', '$event->description', '$event->eventDate')";

        // Executes the  query and returns the result
        return $this->mysqli->query($statement);
    }

    // Get all events
    public function getEvents(){

        // Prepare db-statements
        $statement = "SELECT * FROM t_event";
        $result = mysqli_query($this->mysqli,$statement);

        // Associative array
        $sqlResult = mysqli_fetch_all($result, MYSQLI_ASSOC);

        // creates an Array
        $events =array();
        // Creates and pushes an event for each returned row
        foreach ($sqlResult as &$SqlEvent) {
            $event = new Event();
            $event->id = $SqlEvent['id'];
            $event->heading = $SqlEvent['heading'];
            $event->description = $SqlEvent['description'];
            $event->eventDate = new DateTime($SqlEvent['event_date']);
            array_push($events, $event);
        }
        // Returns an array of event objects 
        return $events;
    }

    // Joins an event
    public function joinEvent($eventId, $userId){

        // Prepares the db-statement 
        $statement = "INSERT INTO `t_event_user` (`event_id`, `user_id`) VALUES ('$eventId','$userId')";

        // Executes the  query and returns the result
        return $this->mysqli->query($statement);
    }

    // Checks if a users is joined an event
    public function isUserJoinedEvent($eventId, $userId){
        
        // Prepare db-statements
        $sql = "SELECT * FROM `t_event_user` WHERE event_id = '$eventId' AND user_id = '$userId'";
        $result = mysqli_query($this->mysqli,$sql);

        // Associative array
        $sqlResult = mysqli_fetch_all($result, MYSQLI_ASSOC);


        // Returns true or false if a row gets returned or not 
        if (count($sqlResult) > 0) {
            return true;
        } else {
            return false;
        }

    }

    // Determines if a user login attempt succeeds or fails
    public function login($email, $password){
        
        // Checks if the user is in the database 
        $user = $this->getUser($email);
    
        // Cecks if a user got returned
        if ($user) {

            // Checks if the provides password matches
            if (password_verify($password, $user->password)) {
                
                // Returns the user
                return $user;
            } else {

                // Password didn't match
                return false;
            }
        } else {
            
            // email is not in the database 
            return false;
        }
    }
}
