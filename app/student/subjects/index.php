<?php
require_once "../../middleware/auth.php";
require_once "../../middleware/role.php";
require_once "../../config/database.php";
checkRole("STUDENT");

$pageTitle      = "My Subjects";
$pageSubtitle   = "Access your subject materials and details.";
$pageIcon       = "bi-book";
$iconColorClass = "icon-green";
$breadcrumbs    = [
    ['label'=>'Dashboard','url'=>'../../dashboard/student.php'],
    ['label'=>'My Learning'],
    ['label'=>'My Subjects'],
];
$quickLinks = [];

require_once "../../includes/header.php";
require_once "../../includes/sidebar_student.php";
require_once "../../includes/navbar.php";
require_once "../../includes/admin_placeholder.php";
