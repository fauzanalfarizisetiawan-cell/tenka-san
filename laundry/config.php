<?php
$host = "127.0.0.1";
$user = "root";
$pass = "";
$db   = "laundry";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Start session if not started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
