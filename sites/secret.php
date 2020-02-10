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

if (isset($_GET['joinEvent'])) {

    $eventId = $_POST['eventId'];
    echo '<script>';
    echo 'console.log(' . json_encode($eventId) . ')';
    echo '</script>';
    $result = $database->joinEvent($eventId, $user->id);
    if ($result && $result !== false) {
        //header("Location: /sites/admin.php", true, 301);
    } else {
        // Dispays an error if the user is invalide 
        $errorMessage = "Ein Fehler ist aufgetreten.<br>";
    }
}
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
    <?php
    // Displays an error message on the site if one is set 
    if (isset($errorMessage)) {
        echo $errorMessage;
    }
    ?>
    <div style=" display: block;margin-left: auto;margin-right: auto;width: max-content;">
        <h1>Offene Termine</h1>
        <?php
        foreach ($events as &$event) { 
            $alreadyJoined = $database->isUserJoinedEvent($event->id, $user->id);?>
            <div class="event-area <?php if ($alreadyJoined) echo 'event-joined' ?>">

                <h2 class="event-heading"> <?php echo $event->heading ?> </h2>
                <h3> <?php echo $event->description ?> </h3>
                <p> Die Veranstaltung findet am <?php echo $event->eventDate ?> statt.</p>
                <form action="?joinEvent=1" method="post">
                    <input type="text" name="eventId" value="<?php echo $event->id ?>" hidden="true">
                    <?php if (!$alreadyJoined) echo '<input type="submit" value="Teilnehem">' ?>
                </form>
            </div>
        <?php
        }
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