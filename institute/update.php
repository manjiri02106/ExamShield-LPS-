<?php
/**
 * ExamShield – Institute Management
 * File : institute/update.php
 * Desc : Handles POST from edit.php — updates existing institute record
 */

session_start();
require_once '../config/database.php';

// Only allow POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit();
}

// Validate ID
if (empty($_POST['id']) || !is_numeric($_POST['id'])) {
    $_SESSION['inst_error'] = 'Invalid institute ID.';
    header('Location: index.php');
    exit();
}

$id = (int) $_POST['id'];

// ── Collect & Sanitize ───────────────────────────────────────────────────────
$institute_name = trim($_POST['institute_name'] ?? '');
$institute_code = trim($_POST['institute_code'] ?? '');
$email          = trim($_POST['email']          ?? '');
$phone          = trim($_POST['phone']          ?? '');
$website        = trim($_POST['website']        ?? '');
$address        = trim($_POST['address']        ?? '');
$city           = trim($_POST['city']           ?? '');
$state          = trim($_POST['state']          ?? '');
$pincode        = trim($_POST['pincode']        ?? '');
$status         = trim($_POST['status']         ?? 'Active');

// ── Server-Side Validation ───────────────────────────────────────────────────
$errors = [];

if (strlen($institute_name) < 3) {
    $errors[] = 'Institute name must be at least 3 characters.';
}
if (empty($institute_code)) {
    $errors[] = 'Institute code is required.';
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Please enter a valid email address.';
}
if (!preg_match('/^[0-9]{10}$/', $phone)) {
    $errors[] = 'Phone number must be exactly 10 digits.';
}
if (empty($address)) {
    $errors[] = 'Address is required.';
}
if (empty($city)) {
    $errors[] = 'City is required.';
}
if (empty($state)) {
    $errors[] = 'State is required.';
}
if (!preg_match('/^[0-9]{6}$/', $pincode)) {
    $errors[] = 'Pincode must be exactly 6 digits.';
}
if (!in_array($status, ['Active', 'Inactive'])) {
    $status = 'Active';
}

if (!empty($errors)) {
    $_SESSION['inst_error'] = implode(' | ', $errors);
    header('Location: edit.php?id=' . $id);
    exit();
}

// ── Update ───────────────────────────────────────────────────────────────────
$sql = "UPDATE institute
        SET institute_name = ?,
            institute_code = ?,
            email          = ?,
            phone          = ?,
            website        = ?,
            address        = ?,
            city           = ?,
            state          = ?,
            pincode        = ?,
            status         = ?
        WHERE id = ?";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param(
    $stmt,
    'ssssssssssi',
    $institute_name,
    $institute_code,
    $email,
    $phone,
    $website,
    $address,
    $city,
    $state,
    $pincode,
    $status,
    $id
);

if (mysqli_stmt_execute($stmt)) {
    $_SESSION['inst_success'] = 'Institute profile updated successfully!';
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    header('Location: index.php');
    exit();
} else {
    $_SESSION['inst_error'] = 'Database error: ' . htmlspecialchars(mysqli_error($conn));
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    header('Location: edit.php?id=' . $id);
    exit();
}