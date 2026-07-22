<?php

require_once "../middleware/auth.php";
require_once "../middleware/role.php";
require_once "../config/database.php";

checkRole("ADMIN");

// Dashboard Statistics

$totalFaculty = 0;
$totalDepartments = 0;

// Total Faculty
$query = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total
     FROM users
     WHERE role='FACULTY'"
);

if ($query) {
    $row = mysqli_fetch_assoc($query);
    $totalFaculty = $row['total'];
}

// Total Departments
$query = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total
     FROM departments"
);

if ($query) {
    $row = mysqli_fetch_assoc($query);
    $totalDepartments = $row['total'];
}

require_once "../includes/header.php";
require_once "../includes/navbar.php";
require_once "../includes/sidebar.php";

?>

<div class="container-fluid">

    <!-- Welcome Card -->

    <div class="row mb-4">

        <div class="col-lg-12">

            <div class="card shadow-sm">

                <div class="card-body">

                    <h2>

                        Welcome,

                        <?php echo htmlspecialchars($_SESSION['name']); ?>

                    </h2>

                    <p class="text-muted mb-0">

                        Manage Faculty members from your dashboard.

                    </p>

                </div>

            </div>

        </div>

    </div>

    <!-- Statistics -->

    <div class="row">

        <div class="col-md-6 mb-4">

            <div class="card bg-success text-white shadow">

                <div class="card-body text-center">

                    <i class="bi bi-mortarboard-fill display-4"></i>

                    <h4 class="mt-3">

                        Faculty

                    </h4>

                    <h1>

                        <?php echo $totalFaculty; ?>

                    </h1>

                </div>

            </div>

        </div>

        <div class="col-md-6 mb-4">

            <div class="card bg-primary text-white shadow">

                <div class="card-body text-center">

                    <i class="bi bi-building-fill display-4"></i>

                    <h4 class="mt-3">

                        Departments

                    </h4>

                    <h1>

                        <?php echo $totalDepartments; ?>

                    </h1>

                </div>

            </div>

        </div>

    </div>

    <!-- Quick Actions -->

    <div class="row">

        <div class="col-lg-6 mb-4">

            <div class="card shadow-sm">

                <div class="card-header">

                    <strong>Quick Actions</strong>

                </div>

                <div class="card-body">

                    <a
                        href="../users/create_faculty.php"
                        class="btn btn-primary w-100 mb-3"
                    >

                        <i class="bi bi-person-plus-fill"></i>

                        Create Faculty

                    </a>

                    <a
                        href="../users/view_faculty.php"
                        class="btn btn-success w-100"
                    >

                        <i class="bi bi-people-fill"></i>

                        View Faculty

                    </a>

                </div>

            </div>

        </div>

        <div class="col-lg-6 mb-4">

            <div class="card shadow-sm">

                <div class="card-header">

                    <strong>System Status</strong>

                </div>

                <div class="card-body">

                    <table class="table table-bordered">

                        <tr>

                            <th width="40%">Application</th>

                            <td>

                                <span class="badge bg-success">

                                    Running

                                </span>

                            </td>

                        </tr>

                        <tr>

                            <th>Database</th>

                            <td>

                                <span class="badge bg-success">

                                    Connected

                                </span>

                            </td>

                        </tr>

                        <tr>

                            <th>Current User</th>

                            <td>

                                <?php echo htmlspecialchars($_SESSION['role']); ?>

                            </td>

                        </tr>

                    </table>

                </div>

            </div>

        </div>

    </div>

</div>

<?php

require_once "../includes/sidebar_admin.php";

?>