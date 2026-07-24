<?php
require_once "../../middleware/auth.php";
require_once "../../middleware/role.php";
require_once "../../config/database.php";
checkRole("ADMIN");

$pageTitle    = "Courses";
$pageSubtitle = "Manage academic courses linked to departments.";
$pageIcon     = "bi-journal-bookmark";
$breadcrumbs  = [
    ['label'=>'Dashboard','url'=>'../../dashboard/admin.php'],
    ['label'=>'Academic'],
    ['label'=>'Courses'],
];
$quickLinks = [['label'=>'Add Course','url'=>'create.php','icon'=>'bi-plus-lg']];

require_once "../../includes/header.php";
require_once "../../includes/sidebar_admin.php";
require_once "../../includes/navbar.php";
require_once "../../includes/admin_placeholder.php";
