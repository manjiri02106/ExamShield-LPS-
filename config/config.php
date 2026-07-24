<?php
/**
 * ==========================================
 * ExamShield LPS
 * Global Configuration File
 * ==========================================
 */

// Start PHP Session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Load Constants
require_once __DIR__ . '/constants.php';

// Set Timezone
date_default_timezone_set(DEFAULT_TIMEZONE); // Uses 'Asia/Kolkata' from constants.php

// Load Database Connection and make it globally available
global $conn;
$conn = require_once __DIR__ . '/database.php';
?>