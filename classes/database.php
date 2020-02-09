<?php

require_once('../classes/user.php');

class Database{

    // Private variable that can only be called inside the class and it's child objects 
    private $database;

    // The constructor gets called when the class gets created 
    public function __construct($host, $dbname, $user, $password){
        $this->database = new PDO('mysql:host=' . $host . ';dbname=' . $dbname, $user, $password);
        $this->database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
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
    public function createUser($email, $password, $userRole){

        // Prepares the db-statement 
        $statement = $this->database->prepare("INSERT INTO `t_user` (`email`, `password`,`user_role`) VALUES (:email,:password,:userRole)");
        $statement->bindParam(':email', $email);
        $statement->bindParam(':password', password_hash($password, PASSWORD_DEFAULT));
        $statement->bindParam(':userRole', $userRole);

        // Executes the  query and returns the result
        return $statement->execute();
    }

    // Delete an User by id
    public function deleteUser($id){
        $query = 'UPDATE `user` SET `active` = 0 WEHRE `id` = ' . $id;
        return $this->query($query);
    }

    // Updates an user by an new user object
    public function updateUser($user){
        // Prepare db-statements
        $statement = $this->database->prepare("UPDATE t_user SET firstname = :firstname , lastname = :lastname  WHERE id = :id");
        $statement->bindParam(':id', $user->id);
        $statement->bindParam(':firstname', $user->firstname);
        $statement->bindParam(':lastname', $user->lastname);

        // Execute query and return
        return $statement->execute();
    }

    // Gets an User by the email
    public function getUser($email){

        $statement = $this->database->prepare("SELECT * FROM t_user WHERE email = :email");
        $result = $statement->execute(array('email' => $email));
        $user = $statement->fetch();
        return $user;
    }

    public function getEvents(){

        $statement = $this->database->prepare("SELECT * FROM t_event");
        $statement->execute();
        $events = $statement->fetchAll();
        echo '<script>';
        echo 'console.log('. json_encode( $events ) .')';
        echo '</script>';
        return $events;
    }

    public function joinEvent($eventId, $userId){

        // Prepares the db-statement 
        $statement = $this->database->prepare("INSERT INTO `t_event_user` (`event_id`, `user_id`) VALUES (:eventId,:userId)");
        $statement->bindParam(':eventId', $eventId);
        $statement->bindParam(':userId', $userId);

        // Executes the  query and returns the result
        return $statement->execute();
    }

    public function isUserJoinedEvent($eventId, $userId){

        // Prepares the db-statement 

        $statement = $this->database->prepare("SELECT * FROM `t_event_user` WHERE event_id = :eventId AND user_id = :userId");
        $statement->bindParam(':eventId', $eventId);
        $statement->bindParam(':userId', $userId);
        
        // Executes the  query and returns the result
        return $statement->execute();
    }
   // Determines if a user login attempt succeeds or fails
    public function login($email, $password){
        $sqlResult = $this->getUser($email);
        if ($sqlResult) {
            if (password_verify($password, $sqlResult['password'])) {
                $loggedinUser = new User();
                $loggedinUser->id = $sqlResult['id'];
                $loggedinUser->email = $sqlResult['email'];
                $loggedinUser->firstname = $sqlResult['firstname'];
                $loggedinUser->lastname = $sqlResult['lastname'];
                $loggedinUser->userRole = $sqlResult['user_role'];

                return $loggedinUser;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}
