<?php
require_once "../../middleware/auth.php";
require_once "../../middleware/role.php";
require_once "../../config/database.php";
checkRole("STUDENT");

$pageTitle      = "Notifications";
$pageSubtitle   = "View announcements and alerts related to your courses.";
$pageIcon       = "bi-bell";
$iconColorClass = "icon-violet";
$breadcrumbs    = [
    ['label'=>'Dashboard','url'=>'../../dashboard/student.php'],
    ['label'=>'Communication'],
    ['label'=>'Notifications'],
];
$quickLinks = [];

require_once "../../includes/header.php";
require_once "../../includes/sidebar_student.php";
require_once "../../includes/navbar.php";
require_once "../../includes/admin_placeholder.php";
