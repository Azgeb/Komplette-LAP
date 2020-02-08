<?php
session_start();
require_once(__DIR__ . '/../modules/config.php');
require_once('../classes/user.php');

if (!isset($_SESSION)) {
    // Asks the user to login if the secret.php got accesed via the searchbar 
    die('Bitte zuerst <a href="login.php">einloggen</a>');
}
// Following code reads the logged in user from the session storage 
$user = new User();
$user = unserialize($_SESSION['user']);

echo '<script>';
echo 'console.log('. json_encode( $user ) .')';
echo '</script>';
?>

<!DOCTYPE html>
<html lang="en">
<title>Website</title>
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
            <li> <a href="../index.html" class="bar-item button padding-large white">Home</a></li>
            <div style="flex-grow: 1;"></div>
            <li><a href="logout.php" class="bar-item button padding-large white">Logout</a></li>
    </div>
    <!-- Content -->
    <div style=" display: block;margin-left: auto;margin-right: auto;width: max-content;">
        <form action="?login=1" method="post">
            Firstname:<br>
            <?php echo (isset($user)) ? $user->firstname : ''; ?><br><br>
            Lastname:<br>
            <?php echo (isset($user)) ? $user->lastname : ''; ?><br>
        </form>
        <form action="?login=1" method="post" hidden="true">
            Firstname:<br>
            <input type="text" size="40" maxlength="250" name="firstname" value="<?php echo (isset($user)) ? $user->firstname : ''; ?>"><br><br>
            Lastname:<br>
            <input type="text" size="40" maxlength="250" name="lastname" value="<?php echo (isset($user)) ? $user->lastname : ''; ?>"><br>

            <button formnovalidate onclick="<?php
                                            $user->lastname = $_POST['lastname'];
                                            $user->firstname = $_POST['firstname'];
                                            $isUpdated = $database->updateUser($user);
                                           
                                            if ($isUpdated) {
                                                $_SESSION['user'] = serialize($user);
                                                header('Refresh: ' . 0);
                                                exit();
                                            }
                                            ?>">update</button>
        </form>
    </div>
    <!-- Footer -->
    <footer class="container padding-64 center opacity">
        <div class="xlarge padding-32">
            <i class="fa fa-github"></i>
        </div>
    </footer>
</body>

</html>