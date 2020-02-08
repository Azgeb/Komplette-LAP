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
    public function createUser($email, $password){

        // Prepares the db-statement 
        $statement = $this->database->prepare("INSERT INTO `users` (`email`, `password`) VALUES (:email,:password)");
        $statement->bindParam(':email', $email);
        $statement->bindParam(':password', password_hash($password, PASSWORD_DEFAULT));

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
        $statement = $this->database->prepare("UPDATE users SET firstname = :firstname , lastname = :lastname  WHERE id = :id");
        $statement->bindParam(':id', $user->id);
        $statement->bindParam(':firstname', $user->firstname);
        $statement->bindParam(':lastname', $user->lastname);

        // Execute query and return
        return $statement->execute();
    }

    // Gets an User by the email
    public function getUser($email){

        $statement = $this->database->prepare("SELECT * FROM users WHERE email = :email");
        $result = $statement->execute(array('email' => $email));
        $user = $statement->fetch();
        return $user;
    }

   // Determines if a user login attempt succeeds or fails
    public function login($email, $password){
        $user = $this->getUser($email);
        if ($user) {
            if (password_verify($password, $user['password'])) {
                $loggedinUser = new User($user);
                return $loggedinUser;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}
