<?php
require_once "../../middleware/auth.php";
require_once "../../middleware/role.php";
require_once "../../config/database.php";
checkRole("ADMIN");

$pageTitle    = "Add Subject";
$pageSubtitle = "Create a new subject under a course.";
$pageIcon     = "bi-book";
$breadcrumbs  = [['label'=>'Dashboard','url'=>'../../dashboard/admin.php'],['label'=>'Subjects','url'=>'index.php'],['label'=>'Add Subject']];
$quickLinks   = [['label'=>'View All','url'=>'index.php','icon'=>'bi-list']];

require_once "../../includes/header.php";
require_once "../../includes/sidebar_admin.php";
require_once "../../includes/navbar.php";
require_once "../../includes/admin_placeholder.php";
