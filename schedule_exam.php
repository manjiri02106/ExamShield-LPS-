<?php
// schedule_exam.php

require_once 'config.php';
require_once 'controllers/ExamController.php';
require_once 'controllers/ScheduleController.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

$examController = new ExamController();
$scheduleController = new ScheduleController();

$success_msg = '';
$error_msg = '';
$exam = null;
$schedule = null;

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $exam = $examController->getExamById($id);
    if($exam) {
        $schedule = $scheduleController->getScheduleByExam($id);
    }
}

// Load the view
require_once 'views/schedule_exam.php';
?>
