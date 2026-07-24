<?php
/**
 * ==========================================
 * ExamShield LPS
 * Database Connection File
 * ==========================================
 * Merged: OOP style (main branch) + Procedural style (Institute/Dept module)
 * Both $conn forms work across all modules.
 */

// We assume constants.php is already loaded before this file.
// Fallback values just in case they aren't defined.
$host = defined('DB_HOST') ? DB_HOST : "localhost";
$username = defined('DB_USER') ? DB_USER : "root";
$password = defined('DB_PASS') ? DB_PASS : "";
$database = defined('DB_NAME') ? DB_NAME : "examshield_lps";

// Create reusable MySQLi Connection (used by Dashboard, Users, Exams, Reports modules)
// mysqli_* procedural functions work directly on the same $conn object as well.
// No second connection needed — mysqli object is dual-use.
$conn = new mysqli($host, $username, $password, $database);

// Handle connection errors properly
if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}

// Set Character Encoding
$conn->set_charset("utf8");

// Return the connection object
return $conn;
?>