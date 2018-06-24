<?php

if (!isset($_SESSION)) {
    session_start();
}

// Allow back button without reposting data
header("Cache-Control: private, no-cache, no-store, proxy-revalidate, no-transform");
//session_cache_limiter("private_no_expire");
date_default_timezone_set('America/Los_Angeles');

define('NEWLINE',  '<br>' );
define('REFRESH_TIME', 'Refresh: 1; ');

$error_msg = [];
$query_msg = [];

define('DB_HOST', "localhost");
define('DB_PORT', "3307");
define('DB_USER', "tool4rentUser");
define('DB_PASS', "12345");
define('DB_SCHEMA', "cs6400_fa17_team004");

$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_SCHEMA, DB_PORT);


if (mysqli_connect_errno())
{
    echo "Failed to connect to MySQL: " . mysqli_connect_error() . NEWLINE;
    echo "Running on: ". DB_HOST . ":". DB_PORT . '<br>' . "Username: " . DB_USER . '<br>' . "Password: " . DB_PASS . '<br>' ."Database: " . DB_SCHEMA;
    phpinfo();   //unsafe, but verbose for learning. 
    exit();
}

?>

