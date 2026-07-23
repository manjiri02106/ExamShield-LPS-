<?php
/**
 * ExamShield – Institute Management
 * File: institute/delete.php
 * Desc: Delete an institute by ID
 */
session_start();
require_once '../config/database.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    $_SESSION['inst_error'] = 'Invalid institute ID.';
    header('Location: index.php'); exit();
}

$id = (int) $_GET['id'];

// Check exists
$chk = mysqli_prepare($conn, 'SELECT institute_name FROM institute WHERE id = ? LIMIT 1');
mysqli_stmt_bind_param($chk, 'i', $id);
mysqli_stmt_execute($chk);
$row = mysqli_fetch_assoc(mysqli_stmt_get_result($chk));
mysqli_stmt_close($chk);

if (!$row) {
    $_SESSION['inst_error'] = 'Institute not found or already deleted.';
    header('Location: index.php'); exit();
}

$stmt = mysqli_prepare($conn, 'DELETE FROM institute WHERE id = ?');
mysqli_stmt_bind_param($stmt, 'i', $id);

if (mysqli_stmt_execute($stmt)) {
    $_SESSION['inst_success'] = "Institute '{$row['institute_name']}' deleted successfully.";
} else {
    $_SESSION['inst_error'] = 'Failed to delete: ' . htmlspecialchars(mysqli_error($conn));
}
mysqli_stmt_close($stmt);
mysqli_close($conn);
header('Location: index.php');
exit();
