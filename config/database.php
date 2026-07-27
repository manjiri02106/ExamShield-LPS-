<?php

$host = "localhost";
$user = "root";
$pass = "";
$db = "examshield";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Database Connection Failed: " . mysqli_connect_error());
}

// Set character encoding
mysqli_set_charset($conn, "utf8");

?>