<?php

require_once('../classes/user.php');
require_once('../classes/internalUser.php');
require_once('../classes/course.php');
require_once('../classes/document.php');

class Database
{

    // Private variable that can only be called inside the class and it's child objects 
    private $database;
    private $mysqli;

    // The constructor gets called when the class gets created 
    public function __construct($host, $dbname, $user, $password)
    {
        // Opens the database connection with the variables from the config.php
        $this->mysqli = new mysqli($host, $user, $password, $dbname);
        if ($this->mysqli->connect_errno) {
            echo "Failed to connect to MySQL: " . $this->mysqli->connect_error;
        }
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
    public function createUser($user)
    {

        // hash th password 
        $hashedPassword = password_hash($user->password, PASSWORD_DEFAULT);
        // Prepares the db-statement 
        $statement = "INSERT INTO `t_user` (`email`, `password`,`course_id`, `firstname`,`lastname`, `postal_code`,`city`, `street`) 
        VALUES ('$user->email','$hashedPassword','$user->courseId','$user->firstname','$user->lastname','$user->postalCode','$user->city','$user->street')";

echo '<script>';
echo 'console.log('. json_encode( $statement ) .')';
echo '</script>';
        // Executes the  query and returns the result
        return  $this->mysqli->query($statement);
    }

    // Create a new user
    public function createInternalUser($internalUser)
    {

        // hash th password 
        $hashedPassword = password_hash($internalUser->password, PASSWORD_DEFAULT);
        // Prepares the db-statement 
        $statement = "INSERT INTO `t_internal_user` (`email`, `password`,`is_administrator`, `firstname`,`lastname`, `postal_code`,`city`, `street`) 
        VALUES ('$internalUser->email','$hashedPassword','$internalUser->isAdministrator','$internalUser->firstname','$internalUser->lastname',
        '$internalUser->postalCode','$internalUser->city','$internalUser->street')";

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
    public function updateUser($user)
    {

        // Prepare db-statements
        $statement = "UPDATE t_user SET firstname = '$user->firstname' , lastname = '$user->lastname'  WHERE id = '$user->id'";

        // Execute query and return
        return  $this->mysqli->query($statement);
    }

    // Gets an user by the email
    public function getUser($email)
    {

        // Prepare db-statements
        $statement = "SELECT * FROM t_user WHERE email = '$email';";
        $result = mysqli_query($this->mysqli, $statement);

        // Associative array
        $sqlResult = mysqli_fetch_array($result, MYSQLI_ASSOC);

        // Creates the user from the returned row if one is returned
        if (count($sqlResult) > 0) {
            $user = new User();
            $user->userId = $sqlResult['user_id'];
            $user->courseId = $sqlResult['course_id'];
            $user->email = $sqlResult['email'];
            $user->password = $sqlResult['password'];
            $user->firstname = $sqlResult['firstname'];
            $user->lastname = $sqlResult['lastname'];
            $user->postalCode = $sqlResult['postalCode'];
            $user->city = $sqlResult['city'];
            $user->street = $sqlResult['street'];
        }
        // Returns the user
        return $user;
    }

    // Gets an user by the email
    public function getInternalUser($email)
    {

        // Prepare db-statements
        $statement = "SELECT * FROM t_internal_user WHERE email = '$email';";
        $result = mysqli_query($this->mysqli, $statement);

        // Associative array
        $sqlResult = mysqli_fetch_array($result, MYSQLI_ASSOC);

        // Creates the user from the returned row if one is returned
        if (count($sqlResult) > 0) {
            $user = new InternalUser();
            $user->internalUserId = $sqlResult['internal_user_id'];
            $user->isAdministrator = $sqlResult['is_administrator'];
            $user->email = $sqlResult['email'];
            $user->password = $sqlResult['password'];
            $user->firstname = $sqlResult['firstname'];
            $user->lastname = $sqlResult['lastname'];
            $user->postalCode = $sqlResult['postalCode'];
            $user->city = $sqlResult['city'];
            $user->street = $sqlResult['street'];
        }
        // Returns the user
        return $user;
    }

    public function getCourse($courseId)
    {

        // Prepare db-statements
        $statement = "SELECT * FROM t_course WHERE course_id = '$courseId';";
        $result = mysqli_query($this->mysqli, $statement);

        // Associative array
        $sqlResult = mysqli_fetch_array($result, MYSQLI_ASSOC);

        // Creates the user from the returned row if one is returned
        if (count($sqlResult) > 0) {
            $course = new Course();
            $course->courseId = $sqlResult['course_id'];
            $course->name = $sqlResult['name'];
            $course->internal_user_id = $sqlResult['internal_user_id'];
        }

        // Returns the user
        return $course;
    }

    // Creates a new event 
    public function createEvent($event)
    {

        // Prepares the db-statement 
        $statement = "INSERT INTO `t_event` (`heading`, `description`, `event_date`) VALUES ('$event->heading', '$event->description', '$event->eventDate')";

        // Executes the  query and returns the result
        return $this->mysqli->query($statement);
    }

    // Get all events
    public function getCourses()
    {

        // Prepare db-statements
        $statement = "SELECT * FROM t_event";
        $result = mysqli_query($this->mysqli, $statement);

        // Associative array
        $sqlResult = mysqli_fetch_all($result, MYSQLI_ASSOC);

        // creates an Array
        $courses = array();
        // Creates and pushes an event for each returned row
        foreach ($sqlResult as &$SqlCourse) {
            $course = new Course();
            $course->courseId = $SqlCourse['course_id'];
            $course->name = $SqlCourse['name'];
            $course->internal_user_id = $SqlCourse['internal_user_id'];
            array_push($courses, $course);
        }
        // Returns an array of event objects 
        return $courses;
    }

    // Joins an event
    public function joinEvent($eventId, $userId)
    {

        // Prepares the db-statement 
        $statement = "INSERT INTO `t_event_user` (`event_id`, `user_id`) VALUES ('$eventId','$userId')";

        // Executes the  query and returns the result
        return $this->mysqli->query($statement);
    }

    // Checks if a users is joined an event
    public function getDocuments($courseId)
    {

        // Prepare db-statements
        $sql = "SELECT * FROM `t_document` WHERE course_id = '$courseId'";
        $result = mysqli_query($this->mysqli, $sql);

        // Associative array
        $sqlResult = mysqli_fetch_all($result, MYSQLI_ASSOC);
        // creates an Array
        $documents = array();
        // Creates and pushes an event for each returned row
        foreach ($sqlResult as &$SqlDocument) {
            $document = new Document();
            $document->documentId = $SqlDocument['document_id'];
            $document->courseId = $SqlDocument['course_id'];
            $document->path = $SqlDocument['path'];
            $document->displayName = $SqlDocument['display_name'];
            array_push($documents, $document);
        }
        // Returns an array of event objects 
        return $documents;
    }

    // Determines if a user login attempt succeeds or fails
    public function login($email, $password)
    {

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

    // Determines if a user login attempt succeeds or fails
    public function loginIntern($email, $password)
    {

        // Checks if the user is in the database 
        $user = $this->getInternalUser($email);
        
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

