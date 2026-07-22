<?php

require_once "../middleware/auth.php";
require_once "../middleware/role.php";
require_once "../config/database.php";

// Only SUPER_ADMIN can access
checkRole("SUPER_ADMIN");

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    die("Invalid Request.");
}

// Get form data
$admin_id = intval($_POST['id']);
$name = trim($_POST['name']);
$email = trim($_POST['email']);
$department_id = intval($_POST['department_id']);

// Basic Validation
if (empty($name) || empty($email) || empty($department_id)) {
    die("All fields are required.");
}

// Check if Admin exists
$sql = "SELECT id
        FROM users
        WHERE id = ?
        AND role = 'ADMIN'";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $admin_id);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("Admin not found.");
}

// Check if email already exists for another user
$sql = "SELECT id
        FROM users
        WHERE email = ?
        AND id != ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $email, $admin_id);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows > 0) {
    die("Email already exists.");
}

// Check department exists
$sql = "SELECT id
        FROM departments
        WHERE id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $department_id);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("Invalid Department.");
}

// Update Admin
$sql = "UPDATE users
        SET
            name = ?,
            email = ?,
            department_id = ?
        WHERE id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param(
    "ssii",
    $name,
    $email,
    $department_id,
    $admin_id
);

if ($stmt->execute()) {

    header("Location: view_admins.php");
    exit();

} else {

    die("Failed to update Admin.");

}

?>