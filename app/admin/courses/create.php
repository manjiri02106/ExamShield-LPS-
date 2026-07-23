<?php
require_once "../../middleware/auth.php";
require_once "../../middleware/role.php";
require_once "../../config/database.php";
checkRole("ADMIN");

$pageTitle    = "Add Course";
$pageSubtitle = "Create a new course for a department.";
$pageIcon     = "bi-journal-bookmark";
$breadcrumbs  = [
    ['label'=>'Dashboard','url'=>'../../dashboard/admin.php'],
    ['label'=>'Courses','url'=>'index.php'],
    ['label'=>'Add Course'],
];
$quickLinks = [['label'=>'View All','url'=>'index.php','icon'=>'bi-list']];

require_once "../../includes/header.php";
require_once "../../includes/sidebar_admin.php";
require_once "../../includes/navbar.php";
require_once "../../includes/admin_placeholder.php";
