<?php

require_once(__DIR__.'/../classes/database.php');
require_once(__DIR__.'/functions.php');
require_once(__DIR__.'/../classes/event.php');
require_once(__DIR__.'/../classes/user.php');

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASSWORD', 'test');
define('DB_NAME', 'LAP');

$database = new Database(DB_HOST, DB_NAME, DB_USER, DB_PASSWORD);
