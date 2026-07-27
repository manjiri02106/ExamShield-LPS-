<?php
require_once "../../middleware/auth.php";
require_once "../../middleware/role.php";
require_once "../../config/database.php";
checkRole("ADMIN");

$pageTitle    = "Reports";
$pageSubtitle = "View results and analytics across departments and exams.";
$pageIcon     = "bi-bar-chart-line";
$breadcrumbs  = [['label'=>'Dashboard','url'=>'../../dashboard/admin.php'],['label'=>'Reports']];
$quickLinks   = [];

require_once "../../includes/header.php";
require_once "../../includes/sidebar_admin.php";
require_once "../../includes/navbar.php";
require_once "../../includes/admin_placeholder.php";
