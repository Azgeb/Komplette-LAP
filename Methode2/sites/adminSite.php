<?php
session_start();
require_once('../modules/config.php');
require_once('../classes/user.php');

// creates a new empty user Object
$user = new User();
/*
unsearialies the previous serialised user 
and saves it as the newly created user
*/
$user = unserialize($_SESSION['user']);
// Gets an array of all user for further processing 
$allUser = $database->getAllUser();
// Gets an array of all internal user for further processing 
$allInternalUser = $database->getAllInternalUser();

// Determins if the User in the session storage is set and an admin
if ($user) {
    /*
    Asks the user to login if the userSite.php got accesed via the searchbar
    and no User is in the session storage
    */
    if ($user->userRole === 0) {
        die('als admin <a href="logout.php">einloggen</a>');
    }

} else {
  // Dies if the user in the session storage is not set
    die('Bitte zuerst <a href="logout.php">einloggen</a>');
}
?>

<!DOCTYPE html>
<html lang="en">
<title>Website</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="stylesheet" href="./../src/css/styles.css">
<link rel="stylesheet" href="./../src/css/navbar.css">
<link rel="stylesheet" href="./../src/css/event.css">

<body>
    <!-- Navbar -->
    <div id="navbar">
        <ul style="display: flex;">
            <li> <a href="../index.html" class="bar-item button padding-large white">Home</a></li>
            <div style="flex-grow: 1;"></div>
            <?php if ($user->isAdministrator == 'y') echo '<li><a href="adminSite.php" class="bar-item button padding-large white">Admin Area</a></li>' ?>
            <li><a href="logout.php" class="bar-item button padding-large white">Logout</a></li>
    </div>
    <!-- Content -->
    <!-- Div that centers the displayed register form -->
    <div style=" display: block;margin-left: auto;margin-right: auto; margin-top: 2rem;width: max-content;">
        <?php
        // Provides a list of links for admin features
        echo 'User <a href="./createUser.php">erstellen</a>';
        ?>

        <h1>Guten Tag, <?php echo $user->firstname, ' ', $user->lastname ?> </h1>
        <h3> Alle Benutzer</h3>
        <table style="width:100%">
            <tr style="text-align: left;">
                <th>Vorname</th>
                <th>Nachname</th>
                <th>EMail</th>
            </tr>
            <?php
            // creates one entry in the html for each object in the allUser array
            foreach ($allUser as $sUser) {
            ?>
            <tr>
                <td><?php echo $sUser->firstname ?></td>
                <td><?php echo $sUser->lastname ?></td>
                <td><?php echo $sUser->email ?></td>
            </tr>
            <?php
            }
            ?>
        </table>
        <h3> Alle Internen Benutzer</h3>
        <table style="width:100%">
            <tr style="text-align: left;">
                <th>Vorname</th>
                <th>Nachname</th>
                <th>EMail</th>
            </tr>
            <?php
            // creates one entry in the html for each object in the allInternalUser array
            foreach ($allInternalUser as $sInternUser) {
            ?>
            <tr>
                <td><?php echo $sInternUser->firstname ?></td>
                <td><?php echo $sInternUser->lastname ?></td>
                <td><?php echo $sInternUser->email ?></td>
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