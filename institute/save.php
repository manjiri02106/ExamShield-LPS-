<?php
/**
 * ExamShield – Institute Management
 * File: institute/save.php
 * Desc: Insert new institute — NO single-record restriction (multi-institute supported)
 */
session_start();
require_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: index.php'); exit(); }

$institute_name = trim($_POST['institute_name'] ?? '');
$institute_code = trim($_POST['institute_code'] ?? '');
$email          = trim($_POST['email']          ?? '');
$phone          = trim($_POST['phone']          ?? '');
$website        = trim($_POST['website']        ?? '');
$address        = trim($_POST['address']        ?? '');
$city           = trim($_POST['city']           ?? '');
$state          = trim($_POST['state']          ?? '');
$pincode        = trim($_POST['pincode']        ?? '');
$status         = in_array($_POST['status'] ?? '', ['Active','Inactive']) ? $_POST['status'] : 'Active';

$errors = [];
if (strlen($institute_name) < 3)                         $errors[] = 'Institute name must be at least 3 characters.';
if (empty($institute_code))                              $errors[] = 'Institute code is required.';
if (!filter_var($email, FILTER_VALIDATE_EMAIL))          $errors[] = 'Valid email is required.';
if (!preg_match('/^[0-9]{10}$/', $phone))               $errors[] = 'Phone must be exactly 10 digits.';
if (empty($address))                                     $errors[] = 'Address is required.';
if (empty($city))                                        $errors[] = 'City is required.';
if (empty($state))                                       $errors[] = 'State is required.';
if (!preg_match('/^[0-9]{6}$/', $pincode))              $errors[] = 'Pincode must be exactly 6 digits.';

if (!empty($errors)) {
    $_SESSION['inst_error'] = implode(' | ', $errors);
    header('Location: add.php'); exit();
}

$sql  = "INSERT INTO institute (institute_name,institute_code,email,phone,website,address,city,state,pincode,status) VALUES (?,?,?,?,?,?,?,?,?,?)";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt,'ssssssssss',$institute_name,$institute_code,$email,$phone,$website,$address,$city,$state,$pincode,$status);

if (mysqli_stmt_execute($stmt)) {
    $_SESSION['inst_success'] = "Institute '$institute_name' added successfully!";
} else {
    $_SESSION['inst_error'] = 'Database error: ' . htmlspecialchars(mysqli_error($conn));
}
mysqli_stmt_close($stmt);
mysqli_close($conn);
header('Location: index.php');
exit();