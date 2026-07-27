<?php
// config.php
session_start();

require_once __DIR__ . '/config/database.php';

$database = new Database();
$pdo = $database->getConnection();

// Dummy Admin Authentication for development
// (Will be replaced by proper login logic, but keeping for UI testing until login is fully connected)
if (!isset($_SESSION['admin_id'])) {
    $_SESSION['admin_id'] = 1;
    $_SESSION['admin_name'] = 'Admin';
    $_SESSION['role'] = 'Admin';
}
?>
