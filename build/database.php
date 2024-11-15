<?php

// Database credentials
define('DB_HOST', 'localhost');
define('DB_NAME', 'usersdb');
define('DB_USER', 'root');
define('DB_PASS', '');

// Create a new MySQLi connection
$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Return the MySQLi object
return $mysqli;
?>
