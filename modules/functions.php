<?php
require_once(__DIR__ . '/../modules/config.php');

function drawEvent($event, $database, $user)
{
    $alreadyJoined = $database->isUserJoinedEvent($event->id, $user->id);
    ?>
    <div class="event-area <?php if($alreadyJoined) echo 'event-joined'?>">
        <h2 class="event-heading"> <?php echo $event->heading ?> </h2>
        <h3> <?php echo $event->description?> </h3>
        <p> Die Veranstaltung findet am <?php echo $event->eventDate?> statt.</p>
        <?php 
        echo '<script>';
        echo 'console.log('. json_encode( 'test' ) .')';
        echo '</script>';
       
        if(!$alreadyJoined) echo' <input type="submit" id="'.$event->id.'" value="insert" onclick="' .$database->joinEvent($event->id, $user->id) . '>Teilnehmen</button>'
        ?>
    </div>

<?php
}
?>