<?php
session_start();
require_once(__DIR__ . '/../modules/config.php');
require_once('../classes/user.php');


$user = new User();
$user = unserialize($_SESSION['user']);

if (!$user || !$user->email) {
    // Asks the user to login if the secret.php got accesed via the searchbar 
    die('Bitte zuerst <a href="login.php">einloggen</a>');
}
// Following code reads the logged in user from the session storage 
$events = $database->getEvents();
?>

<!DOCTYPE html>
<html lang="en">
<title>Website</title>
<?php allHeadEntrys() ?>

<body>
    <!-- Navbar -->
    <div id="navbar">
        <ul style="display: flex;">
            <li> <a href="../index.html" class="bar-item button padding-large white">Home</a></li>
            <div style="flex-grow: 1;"></div>
            <?php if($user->userRole == 0) echo'<li><a href="admin.php" class="bar-item button padding-large white">Admin Area</a></li>'?>
            <li><a href="logout.php" class="bar-item button padding-large white">Logout</a></li>
           
    </div>
    <!-- Content -->
    <div style=" display: block;margin-left: auto;margin-right: auto;width: max-content;">
        <form action="?register=1" method="post">
            <h1>Offene Termine</h1>
            <?php
            foreach ($events as &$event) {
               drawEvent($event,$database, $user);
            }
            ?>
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