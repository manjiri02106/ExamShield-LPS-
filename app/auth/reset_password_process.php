<?php

session_start();

require_once "../config/database.php";

// User must come from forgot password flow
if (!isset($_SESSION["reset_user_id"])) {

    header("Location: forgot_password.php");
    exit();
}

// Allow only POST requests
if ($_SERVER["REQUEST_METHOD"] !== "POST") {

    header("Location: reset_password.php");
    exit();
}

$password = trim($_POST["password"]);
$confirm_password = trim($_POST["confirm_password"]);

// Validation
if (empty($password) || empty($confirm_password)) {

    $_SESSION["error"] = "Please fill in all fields.";

    header("Location: reset_password.php");
    exit();
}

if ($password !== $confirm_password) {

    $_SESSION["error"] = "Passwords do not match.";

    header("Location: reset_password.php");
    exit();
}

if (strlen($password) < 6) {

    $_SESSION["error"] = "Password must be at least 6 characters.";

    header("Location: reset_password.php");
    exit();
}

$userId = $_SESSION["reset_user_id"];

// Currently storing plain text because the project
// is still using plain text authentication.
// Later we'll replace this with password_hash().

$sql = "UPDATE users SET password = ? WHERE id = ?";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param(
    $stmt,
    "si",
    $password,
    $userId
);

if (mysqli_stmt_execute($stmt)) {

    unset($_SESSION["reset_user_id"]);

    $_SESSION["success_message"] =
        "Password updated successfully. Please login.";

    header("Location: login.php");
    exit();

} else {

    $_SESSION["error"] =
        "Unable to update password.";

    header("Location: reset_password.php");
    exit();
}

mysqli_stmt_close($stmt);
mysqli_close($conn);

?>