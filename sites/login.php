<?php
session_start();
require_once(__DIR__ . '/../modules/config.php');

if (isset($_GET['login'])) {
    // Sets up the needed variables 
    $email = $_POST['email'];
    $passwort = $_POST['passwort'];

    // Validates the users provided and stores the user 
    $user = $database->login($email, $passwort);

    // Checks if the user is set and not false and redirects to the secret.php 
    if ($user && $user !== false) {
        $_SESSION['user'] = serialize($user);
        header("Location: /sites/secret.php", true, 301);
    } else {
        // Dispays an error if the user is invalide 
        $errorMessage = "E-Mail oder Passwort war ungültig<br>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<title>Login</title>
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
        <form action="?login=1" method="post">
            E-Mail:<br>
            <input type="email" size="40" maxlength="250" name="email"><br><br>
            Dein Passwort:<br>
            <input type="password" size="40" maxlength="250" name="passwort"><br>
            <a formnovalidate href="/sites/register.php">Registrieren</a>
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