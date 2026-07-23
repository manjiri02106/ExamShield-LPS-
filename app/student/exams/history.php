<?php
require_once "../../middleware/auth.php";
require_once "../../middleware/role.php";
require_once "../../config/database.php";
checkRole("STUDENT");

$pageTitle      = "Exam History";
$pageSubtitle   = "Review the exams you have previously taken.";
$pageIcon       = "bi-clock-history";
$iconColorClass = "icon-cyan";
$breadcrumbs    = [
    ['label'=>'Dashboard','url'=>'../../dashboard/student.php'],
    ['label'=>'Examinations'],
    ['label'=>'Exam History'],
];
$quickLinks = [];

require_once "../../includes/header.php";
require_once "../../includes/sidebar_student.php";
require_once "../../includes/navbar.php";
require_once "../../includes/admin_placeholder.php";
