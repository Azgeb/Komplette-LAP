<?php
session_start();
require_once(__DIR__ . '/../modules/config.php');
require_once('../classes/user.php');

// creates a new empty user Object
$user = new User();
/*
unsearialies the previous serialised user 
and saves it as the newly created user
*/
$user = unserialize($_SESSION['user']);

// Checks if the user is set respectively if the email is set
if (!$user || !$user->email) {
    // Asks the user to login if the userSite.php got accesed via the searchbar 
    die('Bitte zuerst einloggen: <a href="userLogin.php">User</a>  <a href="userLogin.php">Interal User</a>');
}
// Reads all courses from the database 
$course = $database->getCourse($user->courseId);
// Reads all documents, for the course, from the database 
$documents = $database->getDocuments($course->courseId);
?>

<!DOCTYPE html>
<html lang="en">
<title>Logged In</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="stylesheet" href="/../src/css/styles.css">
<link rel="stylesheet" href="/../src/css/navbar.css">
<link rel="stylesheet" href="/../src/css/event.css">

<body>
    <!-- Navbar -->
    <div id="navbar">
        <ul style="display: flex;">
            <li> <a href="../index.html" class="bar-item button padding-large white">Home</a></li>
            <div style="flex-grow: 1;"></div>
            <li><a href="/sites/internLogin.php" class="bar-item button padding-large white">Internes Login</a></li>
            <li><a href="/sites/logout.php" class="bar-item button padding-large white">Logout</a></li>

    </div>
    <!-- Content -->
    <?php
    // Displays an error message on the site if one is set 
    if (isset($errorMessage)) {
        echo $errorMessage;
    }
    ?>
    <div style=" display: block;margin-left: auto;margin-right: auto;width: max-content;">
        <h1>Guten Tag, <?php echo $user->firstname, ' ', $user->lastname ?> </h1>
        <h3>Ihre Dokumente für den Kurs <?php echo $course->name ?> </h3>
        <table style="width:100%">
            <tr style="text-align: left;">
                <th>Dateiname</th>
                <th>Datei</th>
            </tr>
            <?php
            // creates one entry in the html for each object in the courses array
            foreach ($documents as &$document) {
            ?>
            <tr>
                <td><?php echo $document->displayName ?></td>
                <td><a href="../<?php echo $document->path ?>">download</a></td>
            </tr>
            <?php
            }
            ?>
        </table>
    </div>
    <!-- Footer -->
    <footer>
        <div>
            <p>LAP (c) 2020</p>
        </div>
    </footer>
</body>

</html>