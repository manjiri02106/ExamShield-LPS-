<?php
session_start();

require_once "../config/database.php";

// Fetch all departments
$departments = [];

$sql = "SELECT id, department_name FROM departments ORDER BY department_name ASC";
$result = mysqli_query($conn, $sql);

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $departments[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Student Registration | ExamShield</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

</head>

<body class="bg-light">

<div class="container">

    <div class="row justify-content-center mt-5">

        <div class="col-lg-6">

            <div class="card shadow">

                <div class="card-header text-center">

                    <h3>
                        <i class="bi bi-person-plus-fill"></i>
                        Student Registration
                    </h3>

                </div>

                <div class="card-body">

                    <?php if (isset($_SESSION['register_error'])) : ?>

                        <div class="alert alert-danger">

                            <?php
                            echo $_SESSION['register_error'];
                            unset($_SESSION['register_error']);
                            ?>

                        </div>

                    <?php endif; ?>

                    <form action="register_process.php" method="POST">

                        <div class="mb-3">

                            <label class="form-label">
                                Full Name
                            </label>

                            <input
                                type="text"
                                name="name"
                                class="form-control"
                                required>

                        </div>

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
                                Department
                            </label>

                            <select
                                name="department_id"
                                class="form-select"
                                required>

                                <option value="">
                                    Select Department
                                </option>

                                <?php foreach ($departments as $department) : ?>

                                    <option value="<?php echo $department['id']; ?>">

                                        <?php echo htmlspecialchars($department['department_name']); ?>

                                    </option>

                                <?php endforeach; ?>

                            </select>

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
                                class="btn btn-primary">

                                <i class="bi bi-person-check-fill"></i>

                                Register

                            </button>

                        </div>

                    </form>

                    <hr>

                    <div class="text-center">

                        Already have an account?

                        <a href="login.php">

                            Login

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