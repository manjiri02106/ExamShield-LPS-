<?php
// create_exam.php

require_once 'config.php';
require_once 'controllers/ExamController.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

$controller = new ExamController();
$success_msg = "";
$error_msg = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $result = $controller->createExam($_POST);
    if($result['status']) {
        $success_msg = $result['message'];
        header("refresh:2;url=exam_list.php");
    } else {
        $error_msg = $result['message'];
    }
}

$departments = $controller->getDepartments();
$subjects = $controller->getSubjects();

// Load the view
require_once 'views/create_exam.php';
?>
