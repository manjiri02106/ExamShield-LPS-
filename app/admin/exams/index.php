<?php
require_once "../../middleware/auth.php";
require_once "../../middleware/role.php";
require_once "../../config/database.php";
checkRole("ADMIN");

$pageTitle    = "Exams";
$pageSubtitle = "Schedule and manage examinations.";
$pageIcon     = "bi-journal-check";
$breadcrumbs  = [['label'=>'Dashboard','url'=>'../../dashboard/admin.php'],['label'=>'Examination'],['label'=>'Exams']];
$quickLinks   = [['label'=>'Schedule Exam','url'=>'create.php','icon'=>'bi-calendar-plus']];

require_once "../../includes/header.php";
require_once "../../includes/sidebar_admin.php";
require_once "../../includes/navbar.php";
require_once "../../includes/admin_placeholder.php";
