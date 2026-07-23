<?php
session_start();

require_once "../config/database.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: register.php");
    exit();
}

// Get form data
$name = trim($_POST["name"]);
$email = trim($_POST["email"]);
$department_id = trim($_POST["department_id"]);
$password = $_POST["password"];
$confirm_password = $_POST["confirm_password"];

// Validation
if (
    empty($name) ||
    empty($email) ||
    empty($department_id) ||
    empty($password) ||
    empty($confirm_password)
) {
    $_SESSION["register_error"] = "Please fill in all fields.";
    header("Location: register.php");
    exit();
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION["register_error"] = "Invalid email address.";
    header("Location: register.php");
    exit();
}

if ($password !== $confirm_password) {
    $_SESSION["register_error"] = "Passwords do not match.";
    header("Location: register.php");
    exit();
}

if (strlen($password) < 6) {
    $_SESSION["register_error"] = "Password must be at least 6 characters.";
    header("Location: register.php");
    exit();
}

// Check email already exists
$sql = "SELECT id FROM users WHERE email = ?";
$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) > 0) {
    $_SESSION["register_error"] = "Email is already registered.";
    header("Location: register.php");
    exit();
}

mysqli_stmt_close($stmt);

/*
|--------------------------------------------------------------------------
| Password
|--------------------------------------------------------------------------
|
| For now we are storing plain text because the current login system
| is also using plain text.
|
| Next step:
| We'll convert BOTH registration and login to password_hash()
| and password_verify().
|
*/

$storedPassword = $password;

// Insert student
$sql = "INSERT INTO users
(name, email, password, role, department_id, status)
VALUES (?, ?, ?, 'STUDENT', ?, 'ACTIVE')";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param(
    $stmt,
    "sssi",
    $name,
    $email,
    $storedPassword,
    $department_id
);

if (mysqli_stmt_execute($stmt)) {

    $_SESSION["success_message"] =
        "Registration successful. Please login.";

    header("Location: login.php");
    exit();

} else {

    $_SESSION["register_error"] =
        "Registration failed. Please try again.";

    header("Location: register.php");
    exit();
}