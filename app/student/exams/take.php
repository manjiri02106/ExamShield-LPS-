<?php
require_once "../../middleware/auth.php";
require_once "../../middleware/role.php";
require_once "../../config/database.php";
checkRole("STUDENT");

$pageTitle      = "Take Exam";
$pageSubtitle   = "Access the active examination interface.";
$pageIcon       = "bi-pencil-square";
$iconColorClass = "icon-indigo";
$breadcrumbs    = [
    ['label'=>'Dashboard','url'=>'../../dashboard/student.php'],
    ['label'=>'Examinations'],
    ['label'=>'Take Exam'],
];
$quickLinks = [['label'=>'View Upcoming','url'=>'upcoming.php','icon'=>'bi-list']];

require_once "../../includes/header.php";
require_once "../../includes/sidebar_student.php";
require_once "../../includes/navbar.php";
require_once "../../includes/admin_placeholder.php";
