<?php
/**
 * ==========================================
 * ExamShield LPS - Results Modules Controller
 * ==========================================
 */

require_once(__DIR__ . '/database.php');

session_start();

$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'save';
$redirect = isset($_REQUEST['redirect']) ? $_REQUEST['redirect'] : 'marks.php';

if ($action === 'delete') {
    $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
    if ($id > 0) {
        try {
            dbQuery("DELETE FROM results WHERE result_id = ?", [$id]);
            $_SESSION['flash_msg'] = "Result record deleted successfully!";
            $_SESSION['flash_type'] = "success";
        } catch (Exception $e) {
            $_SESSION['flash_msg'] = "Error deleting result: " . $e->getMessage();
            $_SESSION['flash_type'] = "danger";
        }
    }
    header("Location: " . $redirect);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $result_id = isset($_POST['result_id']) && $_POST['result_id'] !== '' ? (int)$_POST['result_id'] : null;
    $student_id = isset($_POST['student_id']) ? (int)$_POST['student_id'] : 0;
    $exam_id = isset($_POST['exam_id']) ? (int)$_POST['exam_id'] : 0;
    $marks = isset($_POST['marks']) ? (float)$_POST['marks'] : 0.00;
    $total_marks = isset($_POST['total_marks']) ? (float)$_POST['total_marks'] : 100.00;

    if ($student_id <= 0 || $exam_id <= 0 || $total_marks <= 0) {
        $_SESSION['flash_msg'] = "Please select valid student, exam, and total marks.";
        $_SESSION['flash_type'] = "warning";
        header("Location: " . $redirect);
        exit;
    }

    $percentage = calculatePercentage($marks, $total_marks);
    $status = calculateStatus($percentage);

    try {
        if ($result_id) {
            dbQuery("
                UPDATE results 
                SET student_id = ?, exam_id = ?, marks_obtained = ?, total_marks = ?, percentage = ?, status = ? 
                WHERE result_id = ?
            ", [$student_id, $exam_id, $marks, $total_marks, $percentage, $status, $result_id]);
            $_SESSION['flash_msg'] = "Marks updated successfully! Percentage: {$percentage}%, Status: {$status}";
            $_SESSION['flash_type'] = "success";
        } else {
            dbQuery("
                INSERT INTO results (student_id, exam_id, marks_obtained, total_marks, percentage, status) 
                VALUES (?, ?, ?, ?, ?, ?)
            ", [$student_id, $exam_id, $marks, $total_marks, $percentage, $status]);
            $_SESSION['flash_msg'] = "Marks saved successfully! Percentage: {$percentage}%, Status: {$status}";
            $_SESSION['flash_type'] = "success";
        }
    } catch (Exception $e) {
        $_SESSION['flash_msg'] = "Database Error: " . $e->getMessage();
        $_SESSION['flash_type'] = "danger";
    }

    header("Location: " . $redirect);
    exit;
}

header("Location: marks.php");
exit;
