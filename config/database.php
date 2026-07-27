<?php

$host = "localhost";
$user = "root";
$pass = "";
$db   = "examshield";   // Changed from examshield_db

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Database Connection Failed");
}

// echo "Connected Successfully"; // Uncomment only for testing

?>