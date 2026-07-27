<?php
require_once "../../middleware/auth.php";
require_once "../../middleware/role.php";
require_once "../../config/database.php";
checkRole("ADMIN");

$pageTitle    = "Students";
$pageSubtitle = "Manage enrolled students across departments.";
$pageIcon     = "bi-mortarboard";
$breadcrumbs  = [
    ['label'=>'Dashboard','url'=>'../../dashboard/admin.php'],
    ['label'=>'Academic'],
    ['label'=>'Students'],
];
$quickLinks = [['label'=>'Add Student','url'=>'create.php','icon'=>'bi-person-plus']];

require_once "../../includes/header.php";
require_once "../../includes/sidebar_admin.php";
require_once "../../includes/navbar.php";
require_once "../../includes/admin_placeholder.php";
