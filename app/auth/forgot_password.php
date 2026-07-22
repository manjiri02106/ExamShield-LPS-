<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Forgot Password | ExamShield</title>

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

                        <i class="bi bi-key-fill"></i>

                        Forgot Password

                    </h3>

                </div>

                <div class="card-body">

                    <?php if(isset($_SESSION['error'])) : ?>

                        <div class="alert alert-danger">

                            <?php
                            echo $_SESSION['error'];
                            unset($_SESSION['error']);
                            ?>

                        </div>

                    <?php endif; ?>

                    <form action="forgot_password_process.php" method="POST">

                        <div class="mb-3">

                            <label class="form-label">

                                Registered Email

                            </label>

                            <input
                                type="email"
                                name="email"
                                class="form-control"
                                required>

                        </div>

                        <div class="d-grid">

                            <button
                                type="submit"
                                class="btn btn-primary">

                                <i class="bi bi-arrow-right-circle"></i>

                                Continue

                            </button>

                        </div>

                    </form>

                    <hr>

                    <div class="text-center">

                        <a href="login.php">

                            Back to Login

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