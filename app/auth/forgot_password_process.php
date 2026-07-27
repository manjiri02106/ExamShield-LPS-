<?php

session_start();

require_once "../config/database.php";

// Allow only POST requests
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: forgot_password.php");
    exit();
}

$email = trim($_POST["email"]);

// Validate email
if (empty($email)) {

    $_SESSION["error"] = "Please enter your registered email.";

    header("Location: forgot_password.php");
    exit();
}

// Check if email exists
$sql = "SELECT id FROM users WHERE email = ? AND status = 'ACTIVE'";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param($stmt, "s", $email);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) == 0) {

    $_SESSION["error"] = "No active account found with this email.";

    header("Location: forgot_password.php");
    exit();
}

$user = mysqli_fetch_assoc($result);

// Store user id in session
$_SESSION["reset_user_id"] = $user["id"];

// Go to password reset page
header("Location: reset_password.php");
exit();

?>