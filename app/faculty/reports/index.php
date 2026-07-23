<?php
require_once "../../middleware/auth.php";
require_once "../../middleware/role.php";
require_once "../../config/database.php";
checkRole("FACULTY");

$pageTitle      = "Reports";
$pageSubtitle   = "View academic and examination analytics.";
$pageIcon       = "bi-bar-chart-line";
$iconColorClass = "icon-violet";
$breadcrumbs    = [
    ['label'=>'Dashboard','url'=>'../../dashboard/faculty.php'],
    ['label'=>'Reports'],
];
$quickLinks = [];

require_once "../../includes/header.php";
require_once "../../includes/sidebar_faculty.php";
require_once "../../includes/navbar.php";
require_once "../../includes/admin_placeholder.php";
