<?php
require_once "../../middleware/auth.php";
require_once "../../middleware/role.php";
require_once "../../config/database.php";
checkRole("ADMIN");

$pageTitle    = "Schedule Exam";
$pageSubtitle = "Create and schedule a new examination.";
$pageIcon     = "bi-calendar-plus";
$breadcrumbs  = [['label'=>'Dashboard','url'=>'../../dashboard/admin.php'],['label'=>'Exams','url'=>'index.php'],['label'=>'Schedule Exam']];
$quickLinks   = [['label'=>'View All Exams','url'=>'index.php','icon'=>'bi-list']];

require_once "../../includes/header.php";
require_once "../../includes/sidebar_admin.php";
require_once "../../includes/navbar.php";
require_once "../../includes/admin_placeholder.php";
