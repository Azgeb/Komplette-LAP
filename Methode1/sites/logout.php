<?php
session_start();
// Destroys the current logged in session
session_destroy();
header("Location: /index.html", true, 301);
?>