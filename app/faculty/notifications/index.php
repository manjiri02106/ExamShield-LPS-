<?php
require_once "../../middleware/auth.php";
require_once "../../middleware/role.php";
require_once "../../config/database.php";
checkRole("FACULTY");

$pageTitle      = "Notifications";
$pageSubtitle   = "View important system announcements and alerts.";
$pageIcon       = "bi-bell";
$iconColorClass = "icon-amber";
$breadcrumbs    = [
    ['label'=>'Dashboard','url'=>'../../dashboard/faculty.php'],
    ['label'=>'Notifications'],
];
$quickLinks = [];

require_once "../../includes/header.php";
require_once "../../includes/sidebar_faculty.php";
require_once "../../includes/navbar.php";
require_once "../../includes/admin_placeholder.php";
