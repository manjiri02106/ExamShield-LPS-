<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>ExamShield Login</title>

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

                        <i class="bi bi-shield-lock-fill"></i>

                        ExamShield Login

                    </h3>

                </div>

                <div class="card-body">

                    <?php if (isset($_SESSION["error"])) : ?>

                        <div class="alert alert-danger">

                            <?php
                            echo $_SESSION["error"];
                            unset($_SESSION["error"]);
                            ?>

                        </div>

                    <?php endif; ?>

                    <?php if (isset($_SESSION["success_message"])) : ?>

                        <div class="alert alert-success">

                            <?php
                            echo $_SESSION["success_message"];
                            unset($_SESSION["success_message"]);
                            ?>

                        </div>

                    <?php endif; ?>

                    <form action="login_process.php" method="POST">

                        <div class="mb-3">

                            <label class="form-label">

                                Email

                            </label>

                            <input
                                type="email"
                                name="email"
                                class="form-control"
                                required>

                        </div>

                        <div class="mb-3">

                            <label class="form-label">

                                Password

                            </label>

                            <input
                                type="password"
                                name="password"
                                class="form-control"
                                required>

                        </div>

                        <div class="d-grid">

                            <button
                                type="submit"
                                class="btn btn-primary">

                                <i class="bi bi-box-arrow-in-right"></i>

                                Login

                            </button>

                        </div>

                    </form>

                    <hr>

                    <div class="text-center">

                        Don't have a student account?
<br><br>

<a href="forgot_password.php">

    Forgot Password?

</a>
                        <a href="register.php">

                            Register

                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>