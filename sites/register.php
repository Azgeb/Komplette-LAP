<?php
session_start();
require_once(__DIR__ . '/../modules/config.php');
?>
<!DOCTYPE html>
<html lang="en">
<title>Register</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">

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
    $showFormular = true;
    if (isset($_GET['register'])) {
        // Sets up the needed variables 
        $error = false;
        $email = $_POST['email'];
        $password = $_POST['password'];
        $passwordConfirm = $_POST['passwordConfirm'];

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            // Displayes a message under the navbar 
            echo 'Bitte eine gültige E-Mail-Adresse eingeben<br>';
            $error = true;
        }
        if (strlen($password) == 0) {
            // Displayes a message under the navbar 
            echo 'Bitte ein password angeben<br>';
            $error = true;
        }
        if ($password != $passwordConfirm) {
            // Displayes a message under the navbar 
            echo 'Die Passwörter müssen übereinstimmen<br>';
            $error = true;
        }
        // Validate that the email is not registered yet 
        if (!$error) {
            $user = $database->getUser($email);

            if ($user !== false) {
               // Displayes a message under the navbar 
                echo 'Diese E-Mail-Adresse ist bereits vergeben<br>';
                $error = true;
            }
        }
        // Regisers a new user 
        if (!$error) {
            $result = $database->createUser($email, $password);
            if ($result) {
                /* 
                Displayes a html tag to confirn the creation of an new user
                and provides a link to th login. 
                */
                echo 'Du wurdest erfolgreich registriert. <a href="/sites/login.php">Zum Login</a>';
                $showFormular = false;
            } else {
                // Displayes a message under the navbar 
                echo 'Beim Abspeichern ist leider ein Fehler aufgetreten<br>';
            }
        }
    }

    if ($showFormular) {
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
    <?php
    }
    ?>
    <!-- Footer -->
    <footer class="container padding-64 center opacity">
        <div class="xlarge padding-32">
            <i class="fa fa-github"></i>
        </div>
    </footer>
</body>

</html>