<?php
/**
 * ExamShield – Department Management
 * File : department/delete.php
 * Desc : Deletes a department by ID — called via redirect from SweetAlert confirm
 */

session_start();
require_once '../config/database.php';

// ── Validate ID ──────────────────────────────────────────────────────────────
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    $_SESSION['dept_error'] = 'Invalid department ID.';
    header('Location: index.php');
    exit();
}

$id = (int) $_GET['id'];

// ── Verify department exists and get name for flash message ──────────────────
$checkStmt = mysqli_prepare($conn, 'SELECT department_name FROM department WHERE id = ? LIMIT 1');
mysqli_stmt_bind_param($checkStmt, 'i', $id);
mysqli_stmt_execute($checkStmt);
$checkResult = mysqli_stmt_get_result($checkStmt);
$existing    = mysqli_fetch_assoc($checkResult);
mysqli_stmt_close($checkStmt);

if (!$existing) {
    $_SESSION['dept_error'] = 'Department not found or already deleted.';
    header('Location: index.php');
    exit();
}

$deptName = $existing['department_name'];

// ── Delete ───────────────────────────────────────────────────────────────────
$stmt = mysqli_prepare($conn, 'DELETE FROM department WHERE id = ?');
mysqli_stmt_bind_param($stmt, 'i', $id);

if (mysqli_stmt_execute($stmt)) {
    $_SESSION['dept_success'] = "Department '$deptName' deleted successfully.";
} else {
    $_SESSION['dept_error'] = 'Failed to delete department: ' . htmlspecialchars(mysqli_error($conn));
}

mysqli_stmt_close($stmt);
mysqli_close($conn);

header('Location: index.php');
exit();