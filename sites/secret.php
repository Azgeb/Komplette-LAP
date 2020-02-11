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

// Checks if the user is set respectively if the email is set
if (!$user || !$user->email) {
    // Asks the user to login if the secret.php got accesed via the searchbar 
    die('Bitte zuerst <a href="login.php">einloggen</a>');
}
// Reads all events from the database 
$events = $database->getEvents();

// Checks if the joinEvent form is submited
if (isset($_GET['joinEvent'])) {
    // sets the submited eventId and joins the event as the logged in user
    $eventId = $_POST['eventId'];
    $result = $database->joinEvent($eventId, $user->id);
    //Checks the response from the database operation
    if ($result && $result !== false) {
        //header("Location: /sites/admin.php", true, 301);
    } else {
        // Sets the errorMessage variable 
        $errorMessage = "Ein Fehler ist aufgetreten.<br>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<title>Logged In</title>
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
    <?php
    // Displays an error message on the site if one is set 
    if (isset($errorMessage)) {
        echo $errorMessage;
    }
    ?>
    <div style=" display: block;margin-left: auto;margin-right: auto;width: max-content;">
        <h1>Offene Termine</h1>
        <?php
        // creates one entry in the html for each object in the events array
        foreach ($events as &$event) {
            // Checks if the user alredy joined an event
            $alreadyJoined = $database->isUserJoinedEvent($event->id, $user->id); ?>
            <div class="event-area <?php
                                    // Sets a HTML class depending on the alreadyJoined variable
                                    if ($alreadyJoined) echo 'event-joined'
                                    ?>">
                <h2 class="event-heading"> <?php echo $event->heading ?> </h2>
                <h3> <?php echo $event->description ?> </h3>
                <p> Die Veranstaltung findet am <?php echo $event->eventDate->format('d.m.Y') ?> statt.</p>
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