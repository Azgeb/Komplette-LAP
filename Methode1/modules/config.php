<?php

require_once('../classes/database.php');
require_once('../classes/internalUser.php');
require_once('../classes/user.php');
require_once('../classes/course.php');

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASSWORD', 'test');
define('DB_NAME', 'onlinekursverwaltung');

$database = new Database(DB_HOST, DB_NAME, DB_USER, DB_PASSWORD);

?>
