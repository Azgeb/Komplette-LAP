<?php

require_once(__DIR__.'/../classes/database.php');
require_once(__DIR__.'/functions.php');
require_once(__DIR__.'/../classes/event.php');
require_once(__DIR__.'/../classes/user.php');

define('DB_HOST', '');
define('DB_USER', '');
define('DB_PASSWORD', '');
define('DB_NAME', '');

$database = new Database(DB_HOST, DB_NAME, DB_USER, DB_PASSWORD);
