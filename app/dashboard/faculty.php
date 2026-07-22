<?php

require_once "../middleware/auth.php";
require_once "../middleware/role.php";
require_once "../config/database.php";

checkRole("FACULTY");

/*
|--------------------------------------------------------------------------
| Dashboard Statistics
|--------------------------------------------------------------------------
*/

$totalStudents = 0;

// Total Students
$query = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total
     FROM users
     WHERE role='STUDENT'"
);

if ($query) {
    $row = mysqli_fetch_assoc($query);
    $totalStudents = $row['total'];
}

require_once "../includes/header.php";
require_once "../includes/navbar.php";
require_once "../includes/sidebar_faculty.php";

?>

<div class="container-fluid">

    <!-- Welcome Card -->

    <div class="row mb-4">

        <div class="col-12">

            <div class="card shadow-sm">

                <div class="card-body">

                    <h2>
                        Welcome,
                        <?php echo htmlspecialchars($_SESSION['name']); ?>
                    </h2>

                    <p class="text-muted mb-0">
                        Manage your students and monitor your examination activities.
                    </p>

                </div>

            </div>

        </div>

    </div>

    <!-- Statistics -->

    <div class="row">

        <!-- Students -->

        <div class="col-md-3 mb-4">

            <div class="card bg-primary text-white shadow">

                <div class="card-body text-center">

                    <i class="bi bi-people-fill display-4"></i>

                    <h5 class="mt-3">Students</h5>

                    <h1><?php echo $totalStudents; ?></h1>

                </div>

            </div>

        </div>

        <!-- Question Bank -->

        <div class="col-md-3 mb-4">

            <div class="card bg-success text-white shadow">

                <div class="card-body text-center">

                    <i class="bi bi-journal-bookmark-fill display-4"></i>

                    <h5 class="mt-3">Question Bank</h5>

                    <h1>-</h1>

                </div>

            </div>

        </div>

        <!-- Exams -->

        <div class="col-md-3 mb-4">

            <div class="card bg-warning text-dark shadow">

                <div class="card-body text-center">

                    <i class="bi bi-calendar-event-fill display-4"></i>

                    <h5 class="mt-3">Exams</h5>

                    <h1>-</h1>

                </div>

            </div>

        </div>

        <!-- Pending Results -->

        <div class="col-md-3 mb-4">

            <div class="card bg-danger text-white shadow">

                <div class="card-body text-center">

                    <i class="bi bi-clipboard-check-fill display-4"></i>

                    <h5 class="mt-3">Pending Results</h5>

                    <h1>-</h1>

                </div>

            </div>

        </div>

    </div>

    <!-- Information Card -->

    <div class="row">

        <div class="col-lg-12">

            <div class="card shadow-sm">

                <div class="card-header">

                    <strong>Faculty Dashboard</strong>

                </div>

                <div class="card-body">

                    <p class="mb-2">
                        Welcome to the Faculty Dashboard.
                    </p>

                    <p class="text-muted mb-0">
                        The Question Bank, Exams and Results modules are currently under development and will become available after the project modules are merged.
                    </p>

                </div>

            </div>

        </div>

    </div>

</div>

<?php

require_once "../includes/footer.php";

?>