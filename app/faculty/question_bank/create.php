<?php
require_once "../../middleware/auth.php";
require_once "../../middleware/role.php";
require_once "../../config/database.php";
checkRole("FACULTY");

$pageTitle      = "Create Question";
$pageSubtitle   = "Add a new MCQ question to the question bank.";
$pageIcon       = "bi-plus-circle";
$iconColorClass = "icon-indigo";
$breadcrumbs    = [
    ['label'=>'Dashboard','url'=>'../../dashboard/faculty.php'],
    ['label'=>'Question Bank','url'=>'index.php'],
    ['label'=>'Create Question'],
];
$quickLinks = [['label'=>'View All Questions','url'=>'index.php','icon'=>'bi-list']];

require_once "../../includes/header.php";
require_once "../../includes/sidebar_faculty.php";
require_once "../../includes/navbar.php";
require_once "../../includes/admin_placeholder.php";
