<?php
require_once "../../middleware/auth.php";
require_once "../../middleware/role.php";
require_once "../../config/database.php";
checkRole("STUDENT");

$pageTitle      = "Results";
$pageSubtitle   = "Check your grades and performance reports.";
$pageIcon       = "bi-award";
$iconColorClass = "icon-red";
$breadcrumbs    = [
    ['label'=>'Dashboard','url'=>'../../dashboard/student.php'],
    ['label'=>'Examinations'],
    ['label'=>'Results'],
];
$quickLinks = [];

require_once "../../includes/header.php";
require_once "../../includes/sidebar_student.php";
require_once "../../includes/navbar.php";
require_once "../../includes/admin_placeholder.php";
