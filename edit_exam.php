<?php
// edit_exam.php

require_once 'config.php';
require_once 'controllers/ExamController.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

$controller = new ExamController();
$success_msg = '';
$error_msg = '';
$exam = null;

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $exam = $controller->getExamById($id);
}

// Load the view
require_once 'views/edit_exam.php';
?>
