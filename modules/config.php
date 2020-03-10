<?php

require_once('../classes/database.php');
require_once('../classes/internalUser.php');
require_once('../classes/user.php');
require_once('../classes/course.php');

define('DB_HOST', '');
define('DB_USER', '');
define('DB_PASSWORD', '');
define('DB_NAME', '');

$database = new Database(DB_HOST, DB_NAME, DB_USER, DB_PASSWORD);

?>
