<?php

$host = "localhost";
$username = "root";
$password = "";
$database = "examshield_lps";

// Create connection
$conn = mysqli_connect($host, $username, $password, $database);

// Check connection
if (!$conn) {
    die("Connection Failed: " . mysqli_connect_error());
}

// Success message (only for testing)
// echo "Database Connected Successfully!";

?>