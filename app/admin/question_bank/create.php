<?php
require_once "../../middleware/auth.php";
require_once "../../middleware/role.php";
require_once "../../config/database.php";
checkRole("ADMIN");

$pageTitle    = "Add Question";
$pageSubtitle = "Add a new MCQ question to the question bank.";
$pageIcon     = "bi-patch-plus";
$breadcrumbs  = [['label'=>'Dashboard','url'=>'../../dashboard/admin.php'],['label'=>'Question Bank','url'=>'index.php'],['label'=>'Add Question']];
$quickLinks   = [['label'=>'View All','url'=>'index.php','icon'=>'bi-list']];

require_once "../../includes/header.php";
require_once "../../includes/sidebar_admin.php";
require_once "../../includes/navbar.php";
require_once "../../includes/admin_placeholder.php";
