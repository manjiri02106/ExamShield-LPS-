<?php
/**
 * ExamShield – Department Management
 * File : department/save.php
 * Desc : Handles POST from add.php — inserts a new department record
 */

session_start();
require_once '../config/database.php';

// Only allow POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit();
}

// ── Safe Migration ───────────────────────────────────────────────────────────
@mysqli_query($conn, "ALTER TABLE department ADD COLUMN IF NOT EXISTS dept_code VARCHAR(20) NOT NULL DEFAULT '' AFTER department_name");
@mysqli_query($conn, "ALTER TABLE department ADD COLUMN IF NOT EXISTS hod VARCHAR(100) NOT NULL DEFAULT '' AFTER dept_code");
@mysqli_query($conn, "ALTER TABLE department ADD COLUMN IF NOT EXISTS institute_id INT DEFAULT NULL AFTER hod");

// ── Collect & Sanitize ───────────────────────────────────────────────────────
$department_name = trim($_POST['department_name'] ?? '');
$dept_code       = strtoupper(trim($_POST['dept_code'] ?? ''));
$hod             = trim($_POST['hod']             ?? '');
$institute_id    = isset($_POST['institute_id']) && is_numeric($_POST['institute_id'])
                   ? (int) $_POST['institute_id'] : null;
$status          = trim($_POST['status'] ?? 'Active');

// ── Server-Side Validation ───────────────────────────────────────────────────
$errors = [];

if (strlen($department_name) < 2) {
    $errors[] = 'Department name must be at least 2 characters.';
}

if (empty($dept_code)) {
    $errors[] = 'Department code is required.';
} elseif (!preg_match('/^[A-Z0-9\-_]{2,20}$/', $dept_code)) {
    $errors[] = 'Department code must be 2–20 uppercase alphanumeric characters.';
}

if (strlen($hod) < 2) {
    $errors[] = 'Head of Department name must be at least 2 characters.';
}

if (empty($institute_id)) {
    $errors[] = 'Please select an institute.';
}

if (!in_array($status, ['Active', 'Inactive'])) {
    $status = 'Active';
}

if (!empty($errors)) {
    $_SESSION['dept_error'] = implode(' | ', $errors);
    header('Location: add.php');
    exit();
}

// ── Check for duplicate dept_code in same institute ──────────────────────────
$dupStmt = mysqli_prepare($conn,
    'SELECT id FROM department WHERE dept_code = ? AND institute_id = ? LIMIT 1');
mysqli_stmt_bind_param($dupStmt, 'si', $dept_code, $institute_id);
mysqli_stmt_execute($dupStmt);
mysqli_stmt_store_result($dupStmt);
if (mysqli_stmt_num_rows($dupStmt) > 0) {
    $_SESSION['dept_error'] = "Department code '$dept_code' already exists for this institute.";
    mysqli_stmt_close($dupStmt);
    mysqli_close($conn);
    header('Location: add.php');
    exit();
}
mysqli_stmt_close($dupStmt);

// ── Insert ───────────────────────────────────────────────────────────────────
$sql  = "INSERT INTO department (department_name, dept_code, hod, institute_id, status)
         VALUES (?, ?, ?, ?, ?)";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, 'sssis', $department_name, $dept_code, $hod, $institute_id, $status);

if (mysqli_stmt_execute($stmt)) {
    $_SESSION['dept_success'] = "Department '$department_name' added successfully!";
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    header('Location: index.php');
    exit();
} else {
    $_SESSION['dept_error'] = 'Database error: ' . htmlspecialchars(mysqli_error($conn));
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    header('Location: add.php');
    exit();
}