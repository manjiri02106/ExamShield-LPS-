<?php
require_once "../../middleware/auth.php";
require_once "../../middleware/role.php";
require_once "../../config/database.php";
checkRole("ADMIN");

$pageTitle    = "Question Bank";
$pageSubtitle = "Manage MCQ questions for examination.";
$pageIcon     = "bi-patch-question";
$breadcrumbs  = [['label'=>'Dashboard','url'=>'../../dashboard/admin.php'],['label'=>'Examination'],['label'=>'Question Bank']];
$quickLinks   = [['label'=>'Add Question','url'=>'create.php','icon'=>'bi-plus-lg']];

require_once "../../includes/header.php";
require_once "../../includes/sidebar_admin.php";
require_once "../../includes/navbar.php";
require_once "../../includes/admin_placeholder.php";
