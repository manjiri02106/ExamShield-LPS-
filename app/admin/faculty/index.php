<?php
require_once "../../middleware/auth.php";
require_once "../../middleware/role.php";
require_once "../../config/database.php";
checkRole("ADMIN");

$pageTitle      = "Faculty";
$pageSubtitle   = "Manage faculty members across departments.";
$pageIcon       = "bi-person-badge";
$iconColorClass = "icon-green";
$breadcrumbs    = [
    ['label'=>'Dashboard','url'=>'../../dashboard/admin.php'],
    ['label'=>'Academic'],
    ['label'=>'Faculty'],
];
$quickLinks = [['label'=>'Add Faculty','url'=>'create.php','icon'=>'bi-person-plus']];

require_once "../../includes/header.php";
require_once "../../includes/sidebar_admin.php";
require_once "../../includes/navbar.php";
require_once "../../includes/admin_placeholder.php";
