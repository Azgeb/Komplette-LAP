<?php
session_start();
require_once(__DIR__ . '/../modules/config.php');

// Checks if the register form is submited
if (isset($_GET['register'])) {
    // Sets up the needed variables 
    $$newUser = new User();
    $error = false;
    $newUser->email = $_POST['email'];
    $newUser->password = $_POST['password'];
    $newUser->userRole = 1;
    $passwordConfirm = $_POST['passwordConfirm'];

    // Checks if the given email is a valide email (formwise)
    if (!filter_var($newUser->email, FILTER_VALIDATE_EMAIL)) {
        // Sets the errorMessage variable
        $errorMessage =  'Bitte eine gültige E-Mail-Adresse eingeben<br>';
        $error = true;
    }

    // Checks if the given email has at least one char
    if (strlen($newUser->password) == 0) {
        // Sets the errorMessage variable
        $errorMessage = 'Bitte ein password angeben<br>';
        $error = true;
    }

    // Checks if the passwords matches
    if ($newUser->password != $passwordConfirm) {
        // Sets the errorMessage variable
        $errorMessage = 'Die Passwörter müssen übereinstimmen<br>';
        $error = true;
    }
    // Validates that the email is not registered yet 
    if (!$error) {
        $databaseUser = $database->getUser($newUser->email);

        // Checks the response from the database
        if ($databaseUser->email) {
            // Sets the errorMessage variable
            $errorMessage =  'Diese E-Mail-Adresse ist bereits vergeben<br>';
            $error = true;
        }
    }
    // Regisers a new user 
    if (!$error) {
        /*
        Sends the user class to the database class and creates 
        a user with userrole 1(user)
        */
        $result = $database->createUser($newUser);
        if ($result) {
            /* 
            Displayes a html tag to confirm the creation of an new user
            and provides a link to th login. 
            */
            $message = 'Du wurdest erfolgreich registriert. <a href="/sites/login.php">Zum Login</a>';
        } else {
            // Sets the errorMessage variable
            $errorMessage =  'Beim Abspeichern ist leider ein Fehler aufgetreten<br>';
        }
    }
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
            <li><a href="/sites/login.php" class="bar-item button padding-large white">Login</a></li>
        </ul>
    </div>
    <!-- Content -->
    <?php
    // Displays an error message on the top of the site if one is set 
    if (isset($errorMessage)) {
        echo $errorMessage;
    }

    // Displays a message on the site if one is set 
    if (isset($message)) {
        echo $message;
    }
    ?>
        <!-- Div that centers the displayed register form -->
        <div style=" display: block;margin-left: auto;margin-right: auto;width: max-content;">
            <form action="?register=1" method="post">
                E-Mail:<br>
                <input type="email" size="40" maxlength="250" name="email"><br><br>
                Dein password:<br>
                <input type="password" size="40" maxlength="250" name="password"><br>
                password wiederholen:<br>
                <input type="password" size="40" maxlength="250" name="passwordConfirm"><br><br>
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