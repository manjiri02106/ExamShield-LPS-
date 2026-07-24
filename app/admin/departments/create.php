<?php
require_once "../../middleware/auth.php";
require_once "../../middleware/role.php";
require_once "../../config/database.php";
checkRole("ADMIN");

$pageTitle      = "Add Department";
$pageSubtitle   = "Create a new academic department.";
$pageIcon       = "bi-diagram-3";
$iconColorClass = "icon-indigo";
$breadcrumbs    = [
    ['label'=>'Dashboard','url'=>'../../dashboard/admin.php'],
    ['label'=>'Departments','url'=>'index.php'],
    ['label'=>'Add Department'],
];
$quickLinks = [['label'=>'View All','url'=>'index.php','icon'=>'bi-list']];

require_once "../../includes/header.php";
require_once "../../includes/sidebar_admin.php";
require_once "../../includes/navbar.php";
require_once "../../includes/admin_placeholder.php";
