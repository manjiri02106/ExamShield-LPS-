<?php
require_once "../../middleware/auth.php";
require_once "../../middleware/role.php";
require_once "../../config/database.php";
checkRole("STUDENT");

$pageTitle      = "My Courses";
$pageSubtitle   = "View details of your enrolled courses.";
$pageIcon       = "bi-journal-bookmark";
$iconColorClass = "icon-indigo";
$breadcrumbs    = [
    ['label'=>'Dashboard','url'=>'../../dashboard/student.php'],
    ['label'=>'My Learning'],
    ['label'=>'My Courses'],
];
$quickLinks = [];

require_once "../../includes/header.php";
require_once "../../includes/sidebar_student.php";
require_once "../../includes/navbar.php";
require_once "../../includes/admin_placeholder.php";
