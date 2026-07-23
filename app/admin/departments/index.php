<?php
require_once "../../middleware/auth.php";
require_once "../../middleware/role.php";
require_once "../../config/database.php";
checkRole("ADMIN");

$pageTitle      = "Departments";
$pageSubtitle   = "Manage academic departments in your institution.";
$pageIcon       = "bi-diagram-3";
$iconColorClass = "icon-indigo";
$breadcrumbs    = [
    ['label'=>'Dashboard','url'=>'../../dashboard/admin.php'],
    ['label'=>'Academic'],
    ['label'=>'Departments'],
];
$quickLinks = [['label'=>'Add Department','url'=>'create.php','icon'=>'bi-plus-lg']];

require_once "../../includes/header.php";
require_once "../../includes/sidebar_admin.php";
require_once "../../includes/navbar.php";
require_once "../../includes/admin_placeholder.php";
