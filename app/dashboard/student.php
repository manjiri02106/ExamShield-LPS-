<?php

require_once "../middleware/auth.php";
require_once "../middleware/role.php";
require_once "../config/database.php";

checkRole("STUDENT");

require_once "../includes/header.php";
require_once "../includes/navbar.php";
require_once "../includes/sidebar_student.php";

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
                        Welcome to the ExamShield Student Portal.
                    </p>

                </div>

            </div>

        </div>

    </div>

    <!-- Dashboard Cards -->

    <div class="row">

        <!-- Upcoming Exams -->

        <div class="col-md-3 mb-4">

            <div class="card bg-primary text-white shadow">

                <div class="card-body text-center">

                    <i class="bi bi-calendar-event-fill display-4"></i>

                    <h5 class="mt-3">Upcoming Exams</h5>

                    <h1>-</h1>

                </div>

            </div>

        </div>

        <!-- Completed Exams -->

        <div class="col-md-3 mb-4">

            <div class="card bg-success text-white shadow">

                <div class="card-body text-center">

                    <i class="bi bi-check-circle-fill display-4"></i>

                    <h5 class="mt-3">Completed Exams</h5>

                    <h1>-</h1>

                </div>

            </div>

        </div>

        <!-- Results -->

        <div class="col-md-3 mb-4">

            <div class="card bg-warning text-dark shadow">

                <div class="card-body text-center">

                    <i class="bi bi-award-fill display-4"></i>

                    <h5 class="mt-3">Results</h5>

                    <h1>-</h1>

                </div>

            </div>

        </div>

        <!-- Attendance -->

        <div class="col-md-3 mb-4">

            <div class="card bg-danger text-white shadow">

                <div class="card-body text-center">

                    <i class="bi bi-person-check-fill display-4"></i>

                    <h5 class="mt-3">Attendance</h5>

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

                    <strong>Student Dashboard</strong>

                </div>

                <div class="card-body">

                    <p class="mb-2">
                        Welcome to the Student Dashboard.
                    </p>

                    <p class="text-muted mb-0">
                        The Exams, Results and Attendance modules will become available after the project modules are merged.
                    </p>

                </div>

            </div>

        </div>

    </div>

</div>

<?php

require_once "../includes/footer.php";

?>