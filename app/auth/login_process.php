<?php

session_start();

require_once "../config/database.php";

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: login.php");
    exit();
}

// Get form data
$email = trim($_POST["email"]);
$password = trim($_POST["password"]);

// Validate input
if (empty($email) || empty($password)) {

    $_SESSION["error"] = "Please fill in all fields.";

    header("Location: login.php");
    exit();
}

// Find active user by email
$sql = "SELECT * FROM users WHERE email = ? AND status = 'ACTIVE'";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param($stmt, "s", $email);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) == 1) {

    $user = mysqli_fetch_assoc($result);

    /*
    |--------------------------------------------------------------------------
    | Password Verification
    |--------------------------------------------------------------------------
    |
    | Currently using plain text passwords.
    | Later we will replace this with:
    |
    | password_verify($password, $user['password'])
    |
    */

    if ($password == $user["password"]) {

        // Store session

        $_SESSION["user_id"] = $user["id"];
        $_SESSION["name"] = $user["name"];
        $_SESSION["email"] = $user["email"];
        $_SESSION["role"] = $user["role"];

        // Redirect according to role

        switch ($user["role"]) {

            case "SUPER_ADMIN":

                header("Location: ../dashboard/super_admin.php");
                exit();

            case "ADMIN":

                header("Location: ../dashboard/admin.php");
                exit();

            case "FACULTY":

                header("Location: ../dashboard/faculty.php");
                exit();

            case "STUDENT":

                header("Location: ../dashboard/student.php");
                exit();

            default:

                $_SESSION["error"] = "Invalid user role.";

                header("Location: login.php");
                exit();
        }

    } else {

        $_SESSION["error"] = "Incorrect password.";

        header("Location: login.php");
        exit();
    }

} else {

    $_SESSION["error"] = "User not found or account is inactive.";

    header("Location: login.php");
    exit();
}

mysqli_stmt_close($stmt);
mysqli_close($conn);

?>