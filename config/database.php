<?php
/**
 * ExamShield LPS – Database Configuration
 * Merged: OOP style (main branch) + Procedural style (Institute/Dept module)
 * Both $conn forms work across all modules.
 */

$host = "localhost";
$username = "root";
$password = "";
$database = "examshield_lps";

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}

// ── Procedural alias (used by Institute & Department module)
// mysqli_* functions work directly on the same $conn object
// No second connection needed — mysqli object is dual-use.

?>