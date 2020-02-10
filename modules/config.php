<?php

require_once(__DIR__.'/../classes/database.php');
require_once(__DIR__.'/functions.php');

define('DB_HOST', '');
define('DB_USER', '');
define('DB_PASSWORD', '');
define('DB_NAME', '');

$database = new Database(DB_HOST, DB_NAME, DB_USER, DB_PASSWORD);
