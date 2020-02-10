<?php
session_start();
require_once(__DIR__ . '/../modules/config.php');

$user = new User();
$user = unserialize($_SESSION['user']);

if (!$user || !$user->userRole == 0) {
    // Asks the user to login if the secret.php got accesed via the searchbar 
    die('Bitte zuerst <a href="login.php">einloggen</a>');
}

if (isset($_GET['register'])) {
    $newEvent = new User();
    $error = false;
    $newEvent->email = $_POST['email'];
    $newEvent->password = $_POST['password'];
    $newEvent->userRole = $_POST['userRole'];

    if (!filter_var($newEvent->email, FILTER_VALIDATE_EMAIL)) {
        // Displayes a message under the navbar 
        $errorMessage = 'Bitte eine gültige E-Mail-Adresse eingeben<br>';
        $error = true;
    }
    if (strlen($newEvent->password) == 0) {
        // Displayes a message under the navbar 
        $errorMessage = 'Bitte ein password angeben<br>';
        $error = true;
    }
    if ($newEvent->password != $_POST['passwordConfirm']) {
        // Displayes a message under the navbar 
        $errorMessage = 'Die Passwörter müssen übereinstimmen<br>';
        $error = true;
    }

    if (!$error) {
        $user = $database->getUser($email);

        if ($user) {
            // Displayes a message under the navbar 
            $errorMessage = 'Diese E-Mail-Adresse ist bereits vergeben<br>';
            $error = true;
        }
    }
    // Regisers a new user 
    if (!$error) {
        $result = $database->createUser($newEvent->email, $newEvent->password, $newEvent->userRole);
        if ($result) {
            /* 
            Displayes a html tag to confirn the creation of an new user
            and provides a link to th login. 
            */
            $errorMessage = 'User wurde erfolgreich registriert.</a>';
        } else {
            // Displayes a message under the navbar 
            $errorMessage = 'Beim Abspeichern ist leider ein Fehler aufgetreten<br>';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<title>Register</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

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
    // Displays an error message on the site if one is set 
    if (isset($errorMessage)) {
        echo $errorMessage;
    }
    ?>
    <!-- Div that centers the displayed register form -->
    <div style=" display: block;margin-left: auto;margin-right: auto;width: max-content;">
        <form action="?register=1" method="post">
            E-Mail:<br>
            <input type="email" size="40" maxlength="250" name="email"><br><br>
            Dein Password:<br>
            <input type="password" size="40" maxlength="250" name="password"><br>
            Password wiederholen:<br>
            <input type="password" size="40" maxlength="250" name="passwordConfirm"><br><br>
            User Rolle<br>
            <select name="userRole">
                <option value="0">Admin</option>
                <option value="1">User</option>
            </select><br><br>
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