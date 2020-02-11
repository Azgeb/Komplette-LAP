<?php
session_start();
require_once(__DIR__ . '/../modules/config.php');

// creates a new empty user Object
$user = new User();
/*
unsearialies the previous serialised user 
and saves it as the newly created user
*/
$user = unserialize($_SESSION['user']);

// Determins if the User in the session storage is set and an admin
if ($user) {
    /*
    Asks the user to login if the secret.php got accesed via the searchbar
    and no User is in the session storage
    */
    if (!$user->userRole == 0) {
        die('als admin <a href="logout.php">einloggen</a>');
    } else {
        // Checks if the createEvent form is submited
        if (isset($_GET['createEvent'])) {
            // Sets up the needed variables 
            $newEvent = new Event();
            $error = false;
            $newEvent->heading = $_POST['heading'];
            $newEvent->description = $_POST['description'];
            $newEvent->eventDate = $_POST['eventDate'];

            // Creates an event in the database
            $result = $database->createEvent($newEvent);
            if ($result && $result !== false) {
                header("Location: /sites/createEvent.php", true, 301);
            } else {
                // Sets the errorMessage variable 
                $errorMessage = "Die Eingabe war ungültig<br>";
            }
        }
    }
} else {
    die('Bitte zuerst <a href="logout.php">einloggen</a>');
}
?>
<!DOCTYPE html>
<html lang="en">
<title>Register</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="stylesheet" href="/../src/css/styles.css">
<link rel="stylesheet" href="/../src/css/navbar.css">

<body>
    <!-- Navbar -->
    <div id="navbar">
        <ul style="display: flex;">
            <li> <a href="index.html" class="bar-item button padding-large white">Home</a></li>
            <div style="flex-grow: 1;"></div>
            <?php if ($user->userRole == 0) echo '<li><a href="admin.php" class="bar-item button padding-large white">Admin Area</a></li>' ?>
            <li><a href="/sites/login.php" class="bar-item button padding-large white">Login</a></li>
        </ul>
    </div>
    <!-- Content -->
    <?php
    // Displays an errorMessage on the site if one is set 
    if (isset($errorMessage)) {
        echo $errorMessage;
    }
    ?>
    <!-- Div that centers the displayed register form -->
    <div style=" display: block;margin-left: auto;margin-right: auto;width: max-content;">
        <form action="?createEvent=1" method="post">
            Überschrift:<br>
            <input type="text" size="40" maxlength="250" name="heading"><br><br>
            Beschreibung:<br>
            <input type="textarea" size="40" maxlength="250" name="description"><br>
            Veranstaltungsdatum:<br>
            <input type="date" size="40" maxlength="250" name="eventDate"><br><br>
            <input type="submit" value="Abschicken">
        </form>
    </div>
    <!-- Footer -->
    <footer>
        <div>
            <p>LAP (c) 2020</p>
        </div>
    </footer>
</body>

</html>