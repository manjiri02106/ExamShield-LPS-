<?php
require_once "../../middleware/auth.php";
require_once "../../middleware/role.php";
require_once "../../config/database.php";
checkRole("FACULTY");

$pageTitle      = "Assigned Exams";
$pageSubtitle   = "View and manage examinations assigned to you.";
$pageIcon       = "bi-journal-check";
$iconColorClass = "icon-green";
$breadcrumbs    = [
    ['label'=>'Dashboard','url'=>'../../dashboard/faculty.php'],
    ['label'=>'Examination'],
    ['label'=>'Assigned Exams'],
];
$quickLinks = [];

require_once "../../includes/header.php";
require_once "../../includes/sidebar_faculty.php";
require_once "../../includes/navbar.php";
require_once "../../includes/admin_placeholder.php";
