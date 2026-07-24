<?php
/**
 * ==========================================
 * Student Result Management & Reports
 * Save / Update / Delete Result Controller
 * ==========================================
 */

require_once(__DIR__ . '/database.php');

session_start();

$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'save';

if ($action === 'delete') {
    $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
    if ($id > 0) {
        try {
            dbQuery("DELETE FROM results WHERE id = ?", [$id]);
            $_SESSION['flash_msg'] = "Result record deleted successfully!";
            $_SESSION['flash_type'] = "success";
        } catch (Exception $e) {
            $_SESSION['flash_msg'] = "Error deleting result: " . $e->getMessage();
            $_SESSION['flash_type'] = "danger";
        }
    }
    header("Location: results.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $result_id = isset($_POST['result_id']) && $_POST['result_id'] !== '' ? (int)$_POST['result_id'] : null;
    $student_id = isset($_POST['student_id']) ? (int)$_POST['student_id'] : 0;
    $exam_id = isset($_POST['exam_id']) ? (int)$_POST['exam_id'] : 0;
    $marks = isset($_POST['marks']) ? (float)$_POST['marks'] : 0.00;
    $total_marks = isset($_POST['total_marks']) ? (float)$_POST['total_marks'] : 100.00;

    if ($student_id <= 0 || $exam_id <= 0 || $total_marks <= 0) {
        $_SESSION['flash_msg'] = "Please provide valid student, exam, and total marks values.";
        $_SESSION['flash_type'] = "warning";
        header("Location: results.php");
        exit;
    }

    // Compute Percentage & Pass/Fail Status automatically
    $percentage = calculatePercentage($marks, $total_marks);
    $status = calculateStatus($percentage);

    try {
        if ($result_id) {
            // Update
            $sql = "UPDATE results SET student_id = ?, exam_id = ?, marks = ?, total_marks = ?, percentage = ?, status = ? WHERE id = ?";
            dbQuery($sql, [$student_id, $exam_id, $marks, $total_marks, $percentage, $status, $result_id]);
            $_SESSION['flash_msg'] = "Result updated successfully! Percentage: {$percentage}%, Status: {$status}";
            $_SESSION['flash_type'] = "success";
        } else {
            // Insert or update on duplicate key (student_id + exam_id)
            $sql = "INSERT INTO results (student_id, exam_id, marks, total_marks, percentage, status) 
                    VALUES (?, ?, ?, ?, ?, ?) 
                    ON DUPLICATE KEY UPDATE marks = VALUES(marks), total_marks = VALUES(total_marks), percentage = VALUES(percentage), status = VALUES(status)";
            dbQuery($sql, [$student_id, $exam_id, $marks, $total_marks, $percentage, $status]);
            $_SESSION['flash_msg'] = "Result saved successfully! Percentage: {$percentage}%, Status: {$status}";
            $_SESSION['flash_type'] = "success";
        }
    } catch (Exception $e) {
        $_SESSION['flash_msg'] = "Database error: " . $e->getMessage();
        $_SESSION['flash_type'] = "danger";
    }

    $redirectUrl = isset($_POST['redirect']) ? $_POST['redirect'] : 'results.php';
    header("Location: " . $redirectUrl);
    exit;
}

header("Location: results.php");
exit;
