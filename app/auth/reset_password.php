<?php
session_start();

if (!isset($_SESSION["reset_user_id"])) {
    header("Location: forgot_password.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Reset Password</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

</head>

<body class="bg-light">

<div class="container">

<div class="row justify-content-center mt-5">

<div class="col-md-5">

<div class="card shadow">

<div class="card-header text-center">

<h3>

<i class="bi bi-lock-fill"></i>

Reset Password

</h3>

</div>

<div class="card-body">

<?php if(isset($_SESSION["error"])) : ?>

<div class="alert alert-danger">

<?php

echo $_SESSION["error"];

unset($_SESSION["error"]);

?>

</div>

<?php endif; ?>

<form action="reset_password_process.php" method="POST">

<div class="mb-3">

<label class="form-label">

New Password

</label>

<input
type="password"
name="password"
class="form-control"
required>

</div>

<div class="mb-4">

<label class="form-label">

Confirm Password

</label>

<input
type="password"
name="confirm_password"
class="form-control"
required>

</div>

<div class="d-grid">

<button
type="submit"
class="btn btn-success">

<i class="bi bi-check-circle"></i>

Update Password

</button>

</div>

</form>

</div>

</div>

</div>

</div>

</div>

</body>

</html>