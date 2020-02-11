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

// Determins if the User in the session storage is set and an admin
if ($user) {
    /*
    Asks the user to login if the secret.php got accesed via the searchbar
    and no User is in the session storage
    */
    if(!$user->userRole == 0){
        die('als admin <a href="logout.php">einloggen</a>');
    }
} else {
    die('Bitte zuerst <a href="logout.php">einloggen</a>');
}
?>

<!DOCTYPE html>
<html lang="en">
<title>Website</title>
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
            <?php if ($user->userRole == 0) echo '<li><a href="admin.php" class="bar-item button padding-large white">Admin Area</a></li>' ?>
            <li><a href="logout.php" class="bar-item button padding-large white">Logout</a></li>
    </div>
    <!-- Content -->
    <!-- Div that centers the displayed register form -->
    <div style=" display: block;margin-left: auto;margin-right: auto; margin-top: 2rem;width: max-content;">
        <?php
        // Provides a list of links for admin features
        echo 'Veranstaltung <a href="/sites/createEvent.php">erstellen</a></br></br>';
        echo 'User <a href="/sites/createUser.php">erstellen</a>';
        ?>
    </div>

    <!-- Footer -->
    <footer>
        <div>
            <p>LAP (c) 2020</p>
        </div>
    </footer>
</body>

</html>