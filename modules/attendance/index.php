<?php

$pageTitle = "Dashboard";

require_once("includes/header.php");

?>

<div class="container-fluid mt-4">

    <div class="row mb-4">

        <div class="col-md-12">
            <h2 class="text-primary">
                Welcome to ExamShield LPS
            </h2>
            <p class="text-muted">
                Student Evaluation & Result Management System
            </p>
        </div>

    </div>

    <!-- Dashboard Cards -->

    <div class="row">

        <div class="col-md-3 mb-4">
            <div class="card shadow text-center">
                <div class="card-body">
                    <i class="fas fa-user-graduate fa-3x text-primary mb-3"></i>
                    <h5>Total Students</h5>
                    <h2>250</h2>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card shadow text-center">
                <div class="card-body">
                    <i class="fas fa-file-alt fa-3x text-success mb-3"></i>
                    <h5>Total Exams</h5>
                    <h2>18</h2>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card shadow text-center">
                <div class="card-body">
                    <i class="fas fa-chart-line fa-3x text-warning mb-3"></i>
                    <h5>Results Generated</h5>
                    <h2>190</h2>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card shadow text-center">
                <div class="card-body">
                    <i class="fas fa-calendar-check fa-3x text-danger mb-3"></i>
                    <h5>Attendance</h5>
                    <h2>95%</h2>
                </div>
            </div>
        </div>

    </div>

    <!-- Quick Links -->

    <div class="row">

        <div class="col-md-6">

            <div class="card shadow">

                <div class="card-header bg-primary text-white">
                    Your Modules
                </div>

                <div class="card-body">

                    <div class="list-group">

                        <a href="modules/automatic_evaluation/index.php" class="list-group-item list-group-item-action">
                            Automatic Evaluation
                        </a>

                        <a href="modules/result_generation/index.php" class="list-group-item list-group-item-action">
                            Result Generation
                        </a>

                        <a href="modules/marks/index.php" class="list-group-item list-group-item-action">
                            Marks Management
                        </a>

                        <a href="modules/attendance/index.php" class="list-group-item list-group-item-action">
                            Attendance Report
                        </a>

                        <a href="modules/department_reports/index.php" class="list-group-item list-group-item-action">
                            Department Reports
                        </a>

                        <a href="modules/analytics/index.php" class="list-group-item list-group-item-action">
                            Analytics Dashboard
                        </a>

                    </div>

                </div>

            </div>

        </div>

        <div class="col-md-6">

            <div class="card shadow">

                <div class="card-header bg-success text-white">
                    Recent Activity
                </div>

                <div class="card-body">

                    <table class="table table-striped">

                        <thead>

                            <tr>
                                <th>Date</th>
                                <th>Activity</th>
                            </tr>

                        </thead>

                        <tbody>

                            <tr>
                                <td>22-07-2026</td>
                                <td>Attendance Updated</td>
                            </tr>

                            <tr>
                                <td>22-07-2026</td>
                                <td>Results Generated</td>
                            </tr>

                            <tr>
                                <td>21-07-2026</td>
                                <td>Exam Evaluated</td>
                            </tr>

                            <tr>
                                <td>20-07-2026</td>
                                <td>Department Report Created</td>
                            </tr>

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

</div>

<?php

require_once("includes/footer.php");

?>