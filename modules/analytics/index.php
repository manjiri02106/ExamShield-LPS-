<?php

$pageTitle = "Dashboard";

require_once("includes/header.php");

?>

<div class="container-fluid mt-4">

    <div class="row">

        <div class="col-12">
            <h2 class="mb-4">
                Welcome to ExamShield LPS
            </h2>
        </div>

    </div>

    <!-- Dashboard Cards -->

    <div class="row">

        <div class="col-md-3 mb-4">

            <div class="card shadow border-0">

                <div class="card-body text-center">

                    <i class="fas fa-user-graduate fa-3x text-primary mb-3"></i>

                    <h5>Total Students</h5>

                    <h2>250</h2>

                </div>

            </div>

        </div>

        <div class="col-md-3 mb-4">

            <div class="card shadow border-0">

                <div class="card-body text-center">

                    <i class="fas fa-book fa-3x text-success mb-3"></i>

                    <h5>Total Exams</h5>

                    <h2>20</h2>

                </div>

            </div>

        </div>

        <div class="col-md-3 mb-4">

            <div class="card shadow border-0">

                <div class="card-body text-center">

                    <i class="fas fa-chart-line fa-3x text-warning mb-3"></i>

                    <h5>Results Generated</h5>

                    <h2>180</h2>

                </div>

            </div>

        </div>

        <div class="col-md-3 mb-4">

            <div class="card shadow border-0">

                <div class="card-body text-center">

                    <i class="fas fa-calendar-check fa-3x text-danger mb-3"></i>

                    <h5>Attendance</h5>

                    <h2>95%</h2>

                </div>

            </div>

        </div>

    </div>

    <!-- Modules -->

    <div class="row">

        <div class="col-md-6 mb-4">

            <div class="card shadow">

                <div class="card-header bg-primary text-white">

                    Your Assigned Modules

                </div>

                <div class="card-body">

                    <ul class="list-group">

                        <li class="list-group-item">
                            Automatic Evaluation
                        </li>

                        <li class="list-group-item">
                            Result Generation
                        </li>

                        <li class="list-group-item">
                            Marks
                        </li>

                        <li class="list-group-item">
                            Attendance Report
                        </li>

                        <li class="list-group-item">
                            Department Reports
                        </li>

                        <li class="list-group-item">
                            Analytics Dashboard
                        </li>

                    </ul>

                </div>

            </div>

        </div>

        <div class="col-md-6 mb-4">

            <div class="card shadow">

                <div class="card-header bg-success text-white">

                    Quick Actions

                </div>

                <div class="card-body">

                    <a href="modules/automatic_evaluation/index.php" class="btn btn-primary m-2">
                        Automatic Evaluation
                    </a>

                    <a href="modules/result_generation/index.php" class="btn btn-success m-2">
                        Result Generation
                    </a>

                    <a href="modules/attendance/index.php" class="btn btn-warning m-2">
                        Attendance
                    </a>

                    <a href="modules/analytics/index.php" class="btn btn-info m-2">
                        Analytics
                    </a>

                </div>

            </div>

        </div>

    </div>

</div>

<?php

require_once("includes/footer.php");

?>