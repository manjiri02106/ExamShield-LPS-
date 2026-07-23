<?php
require_once "../../middleware/auth.php";
require_once "../../middleware/role.php";
require_once "../../config/database.php";
checkRole("FACULTY");

$pageTitle      = "Manage Questions";
$pageSubtitle   = "Manage the questions you have created.";
$pageIcon       = "bi-patch-question";
$iconColorClass = "icon-indigo";
$breadcrumbs    = [
    ['label'=>'Dashboard','url'=>'../../dashboard/faculty.php'],
    ['label'=>'My Work'],
    ['label'=>'Question Bank'],
];
$quickLinks = [['label'=>'Create Question','url'=>'create.php','icon'=>'bi-plus-circle']];

require_once "../../includes/header.php";
require_once "../../includes/sidebar_faculty.php";
require_once "../../includes/navbar.php";
require_once "../../includes/admin_placeholder.php";
