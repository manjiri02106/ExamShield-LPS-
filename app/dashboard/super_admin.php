<?php

require_once "../middleware/auth.php";
require_once "../middleware/role.php";
require_once "../config/database.php";

checkRole("SUPER_ADMIN");

/*
|--------------------------------------------------------------------------
| Dashboard Statistics
|--------------------------------------------------------------------------
*/

$totalAdmins = 0;
$activeAdmins = 0;
$inactiveAdmins = 0;
$totalDepartments = 0;

// Total Admins
$query = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total
     FROM users
     WHERE role='ADMIN'"
);

if ($query) {
    $row = mysqli_fetch_assoc($query);
    $totalAdmins = $row['total'];
}

// Active Admins
$query = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total
     FROM users
     WHERE role='ADMIN'
     AND status='ACTIVE'"
);

if ($query) {
    $row = mysqli_fetch_assoc($query);
    $activeAdmins = $row['total'];
}

// Inactive Admins
$query = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total
     FROM users
     WHERE role='ADMIN'
     AND status='INACTIVE'"
);

if ($query) {
    $row = mysqli_fetch_assoc($query);
    $inactiveAdmins = $row['total'];
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

                        Manage your Proctored Examination System from one place.

                    </p>

                </div>

            </div>

        </div>

    </div>

    <!-- Statistics -->

    <div class="row">

        <!-- Total Admins -->

        <div class="col-md-3 mb-4">

            <div class="card bg-primary text-white shadow">

                <div class="card-body text-center">

                    <i class="bi bi-people-fill display-4"></i>

                    <h4 class="mt-3">

                        Total Admins

                    </h4>

                    <h1>

                        <?php echo $totalAdmins; ?>

                    </h1>

                </div>

            </div>

        </div>

        <!-- Active Admins -->

        <div class="col-md-3 mb-4">

            <div class="card bg-success text-white shadow">

                <div class="card-body text-center">

                    <i class="bi bi-person-check-fill display-4"></i>

                    <h4 class="mt-3">

                        Active Admins

                    </h4>

                    <h1>

                        <?php echo $activeAdmins; ?>

                    </h1>

                </div>

            </div>

        </div>

        <!-- Inactive Admins -->

        <div class="col-md-3 mb-4">

            <div class="card bg-danger text-white shadow">

                <div class="card-body text-center">

                    <i class="bi bi-person-x-fill display-4"></i>

                    <h4 class="mt-3">

                        Inactive Admins

                    </h4>

                    <h1>

                        <?php echo $inactiveAdmins; ?>

                    </h1>

                </div>

            </div>

        </div>

        <!-- Departments -->

        <div class="col-md-3 mb-4">

            <div class="card bg-warning text-dark shadow">

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

    <!-- Quick Actions & System Status -->

    <div class="row">

        <!-- Quick Actions -->

        <div class="col-lg-6 mb-4">

            <div class="card shadow-sm">

                <div class="card-header">

                    <strong>Quick Actions</strong>

                </div>

                <div class="card-body">

                    <a
                        href="../users/create_admin.php"
                        class="btn btn-primary w-100 mb-3">

                        <i class="bi bi-person-plus-fill"></i>

                        Create Admin

                    </a>

                    <a
                        href="../users/view_admins.php"
                        class="btn btn-success w-100">

                        <i class="bi bi-people-fill"></i>

                        View Admins

                    </a>

                </div>

            </div>

        </div>

        <!-- System Status -->

        <div class="col-lg-6 mb-4">

            <div class="card shadow-sm">

                <div class="card-header">

                    <strong>System Status</strong>

                </div>

                <div class="card-body">

                    <table class="table table-bordered align-middle">

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

require_once "../includes/sidebar_super_admin.php";

?>