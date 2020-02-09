<?php
require_once(__DIR__ . '/../modules/config.php');

function allHeadEntrys()
{ ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="/../src/css/styles.css">
    <link rel="stylesheet" href="/../src/css/navbar.css">
    <link rel="stylesheet" href="/../src/css/event.css">
<?php
}
?>

<?php
function drawEvent($event, $database, $user)
{ 
    $alreadyJoined = $database->isUserJoinedEvent($event['id'], $user->id);
    ?>
    <div class="event-area <?php if($alreadyJoined) echo 'event-joined'?>">
        <h2 class="event-heading"> <?php echo $event['heading'] ?> </h2>
        <p> <?php echo $event['description']?> </p>
        <?php if(!$alreadyJoined) echo'<button onclick="' .$database->joinEvent($event['id'], $user->id) . '">Teilnehmen</button>'?>
    </div>

<?php
}
?>