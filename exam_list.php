<?php
// exam_list.php

require_once 'config.php';
require_once 'controllers/ExamController.php';

// Check auth
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

$controller = new ExamController();
$exams = $controller->getExamList();

// Load the view
require_once 'views/exam_list.php';
?>
