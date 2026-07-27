<?php
// dashboard.php

require_once 'config.php';
require_once 'controllers/DashboardController.php';

// Ensure user is authenticated (auth logic from config.php applies)

$controller = new DashboardController();
$stats = $controller->getStats();

// Load the view
require_once 'views/dashboard.php';
?>
