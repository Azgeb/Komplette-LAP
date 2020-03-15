<?php
require_once ('../classes/user.php');
require_once ('../classes/course.php');
require_once ('../classes/document.php');
class Database {
    // Private variable that can only be called inside the class and it's child objects
    private $mysqli;
    // The constructor gets called when the class gets created
    public function __construct($host, $dbname, $user, $password) {
        // Opens the database connection with the variables from the config.php
        $this->mysqli = new mysqli($host, $user, $password, $dbname);
        if ($this->mysqli->connect_errno) {
            echo "Failed to connect to MySQL: " . $this->mysqli->connect_error;
        }
    }
    // Database-Getter
    public function getDatabase() {
        return $this->mysqli;
    }
    // Create a new user
    public function createUser($user) {
        // hash the password
        $hashedPassword = password_hash($user->password, PASSWORD_DEFAULT);
        // Prepares the db-statement
        $statement = "INSERT INTO `t_user` (`email`, `password`,`course_id`, `firstname`,`lastname`, `postal_code`,`city`, `street`, `user_role`) 
        VALUES ('$user->email','$hashedPassword','$user->courseId','$user->firstname','$user->lastname','$user->postalCode','$user->city','$user->street','$user->userRole')";
        // Executes the  query and returns the result
        return $this->mysqli->query($statement);
    }
    // Create a new internal user
    public function createInternalUser($user) {
        // hash th password
        $hashedPassword = password_hash($user->password, PASSWORD_DEFAULT);
        // Prepares the db-statement
        $statement = "INSERT INTO `t_user` (`email`, `password`,`is_administrator`, `firstname`,`lastname`, `postal_code`,`city`, `street`, `user_role`) 
        VALUES ('$user->email','$hashedPassword','$user->isAdministrator','$user->firstname','$user->lastname',
        '$user->postalCode','$user->city','$user->street', '$user->userRole')";
        // Executes the  query and returns the result
        return $this->mysqli->query($statement);
    }
    // Updates an user by an new user object
    public function updateUser($user) {
        // Prepare db-statements
        $statement = "UPDATE t_user SET firstname = '$user->firstname' , lastname = '$user->lastname'  WHERE id = '$user->id'";
        // Execute query and returns the result
        return $this->mysqli->query($statement);
    }
    // Gets an user by the email
    public function getUser($email) {
        // Prepare db-statements
        $statement = "SELECT * FROM t_user u WHERE u.email = '$email' and u.user_role = 2 ;";
        // Executes the query
        $result = mysqli_query($this->mysqli, $statement);
        // Creates an associative array from the result
        $sqlResult = mysqli_fetch_array($result, MYSQLI_ASSOC);
        // Creates the user from the returned row if one is returned
        if (count($sqlResult) > 0) {
            // Creates an new user
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
        // Returns the created user
        return $user;
    }
    // Gets all user from the database
    public function getAllUser() {
        // Prepare db-statements
        $statement = "SELECT * FROM t_user;";
        // Executes the query
        $result = mysqli_query($this->mysqli, $statement);
        // Creates an associative array from the result
        $sqlResult = mysqli_fetch_all($result, MYSQLI_ASSOC);
        // Creates a empty array
        $allUser = array();
        // Creates and pushes an user for each returned row
        foreach ($sqlResult as & $SqlUser) {
            // Creates an new user
            $user = new User();
            $user->userId = $SqlUser['user_id'];
            $user->courseId = $SqlUser['course_id'];
            $user->email = $SqlUser['email'];
            $user->password = $SqlUser['password'];
            $user->firstname = $SqlUser['firstname'];
            $user->lastname = $SqlUser['lastname'];
            $user->postalCode = $SqlUser['postalCode'];
            $user->city = $SqlUser['city'];
            $user->street = $SqlUser['street'];
            // Pushes the newly created user to the array
            array_push($allUser, $user);
        }
        // Returns the user array
        return $allUser;
    }
    // Gets all internal user from the database
    public function getAllInternalUser() {
        // Prepare db-statements
        $statement = "SELECT * FROM t_user u where u.user_role in (0,1);";
        // Executes the query
        $result = mysqli_query($this->mysqli, $statement);
        // Creates an associative array from the result
        $sqlResult = mysqli_fetch_all($result, MYSQLI_ASSOC);
        // Creates a empty array
        $users = array();
        // Creates and pushes an internal user for each returned row
        foreach ($sqlResult as $SqlUser) {
            // Creates an new user
            $user = new User();
            $user->userId = $SqlUser['internal_user_id'];
            $user->email = $SqlUser['email'];
            $user->password = $SqlUser['password'];
            $user->firstname = $SqlUser['firstname'];
            $user->lastname = $SqlUser['lastname'];
            $user->postalCode = $SqlUser['postalCode'];
            $user->city = $SqlUser['city'];
            $user->street = $SqlUser['street'];
            $user->userRole = $SqlUser['user_role'];
            // Pushes the newly created user to the array
            array_push($internlaUsers, $users);
        }
        // Returns an array of user objects
        return $internlaUsers;
    }
    // Gets an internal user by the email
    public function getInternalUser($email) {
        // Prepare db-statements
        $statement = "SELECT * FROM t_user u WHERE u.email = '$email' and u.user_role in (0,1);";
        // Executes the query
        $result = mysqli_query($this->mysqli, $statement);
        // Creates an associative array from the result
        $sqlResult = mysqli_fetch_array($result, MYSQLI_ASSOC);
        // Creates the user from the returned row if one is returned
        if (count($sqlResult) > 0) {
            // Creates an new user
            $user = new User();
            $user->email = $sqlResult['email'];
            $user->password = $sqlResult['password'];
            $user->firstname = $sqlResult['firstname'];
            $user->lastname = $sqlResult['lastname'];
            $user->postalCode = $sqlResult['postal_code'];
            $user->city = $sqlResult['city'];
            $user->street = $sqlResult['street'];
            $user->userRole = $sqlResult['user_role'];
        }
        // Returns the user
        return $user;
    }
    // Gets an course by it's id
    public function getCourse($courseId) {
        // Prepare db-statements
        $statement = "SELECT * FROM t_course WHERE course_id = '$courseId';";
        // Executes the query
        $result = mysqli_query($this->mysqli, $statement);
        // Creates an associative array from the result
        $sqlResult = mysqli_fetch_array($result, MYSQLI_ASSOC);
        // Creates the course from the returned row if one is returned
        if (count($sqlResult) > 0) {
            // Creates an new course
            $course = new Course();
            $course->courseId = $sqlResult['course_id'];
            $course->name = $sqlResult['name'];
            $course->userId = $sqlResult['user_id'];
        }
        // Returns the course
        return $course;
    }
    // Gets all courses
    public function getCourses() {
        // Prepare db-statements
        $statement = "SELECT * FROM t_course";
        // Executes the query
        $result = mysqli_query($this->mysqli, $statement);
        // Creates an associative array from the result
        $sqlResult = mysqli_fetch_all($result, MYSQLI_ASSOC);
        // creates an empty array
        $courses = array();
        // Creates and pushes an course for each returned row
        foreach ($sqlResult as & $SqlCourse) {
            // Creates an new course
            $course = new Course();
            $course->courseId = $SqlCourse['course_id'];
            $course->name = $SqlCourse['name'];
            $course->userId = $SqlCourse['user_id'];
            // Pushes the newly created course into the array
            array_push($courses, $course);
        }
        // Returns an array of course objects
        return $courses;
    }
    // Gets all documents for a specific courseId
    public function getDocuments($courseId) {
        // Prepare db-statements
        $sql = "SELECT * FROM `t_document` WHERE course_id = '$courseId'";
        // Executes the query
        $result = mysqli_query($this->mysqli, $sql);
        // Creates an associative array from the result
        $sqlResult = mysqli_fetch_all($result, MYSQLI_ASSOC);
        // creates an empty array
        $documents = array();
        // Creates and pushes a document for each returned row
        foreach ($sqlResult as & $SqlDocument) {
            // Creates a new document
            $document = new Document();
            $document->documentId = $SqlDocument['document_id'];
            $document->courseId = $SqlDocument['course_id'];
            $document->path = $SqlDocument['path'];
            $document->displayName = $SqlDocument['display_name'];
            // Pushes the newly created document into the array
            array_push($documents, $document);
        }
        // Returns an array of document objects
        return $documents;
    }
    // Determines if a user login attempt succeeds or fails
    public function login($email, $password) {
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
    // Determines if a internal user login attempt succeeds or fails
    public function loginIntern($email, $password) {
        // Checks if the internal user is in the database
        $user = $this->getInternalUser($email);
        // Cecks if a internal user got returned
        if ($user) {
            // Checks if the provides password matches
            if (password_verify($password, $user->password)) {
                // Returns the internal user
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
