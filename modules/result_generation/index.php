<?php

$pageTitle = "Result Generation";

require_once("../../includes/header.php");
require_once("../../config/database.php");

?>

<div class="container-fluid mt-4">

    <div class="row mb-4">

        <div class="col-md-12">

            <h2>
                <i class="fas fa-graduation-cap text-success"></i>
                Result Generation Dashboard
            </h2>

            <p class="text-muted">
                Manage student results, marksheets and reports.
            </p>

        </div>

    </div>

    <!-- Dashboard Cards -->

    <div class="row">

        <div class="col-md-3 mb-4">

            <div class="card shadow border-0">

                <div class="card-body text-center">

                    <i class="fas fa-users fa-3x text-primary mb-3"></i>

                    <h5>Total Students</h5>

                    <h2>250</h2>

                </div>

            </div>

        </div>

        <div class="col-md-3 mb-4">

            <div class="card shadow border-0">

                <div class="card-body text-center">

                    <i class="fas fa-check-circle fa-3x text-success mb-3"></i>

                    <h5>Pass</h5>

                    <h2>210</h2>

                </div>

            </div>

        </div>

        <div class="col-md-3 mb-4">

            <div class="card shadow border-0">

                <div class="card-body text-center">

                    <i class="fas fa-times-circle fa-3x text-danger mb-3"></i>

                    <h5>Fail</h5>

                    <h2>40</h2>

                </div>

            </div>

        </div>

        <div class="col-md-3 mb-4">

            <div class="card shadow border-0">

                <div class="card-body text-center">

                    <i class="fas fa-chart-line fa-3x text-warning mb-3"></i>

                    <h5>Pass %</h5>

                    <h2>84%</h2>

                </div>

            </div>

        </div>

    </div>

    <!-- Quick Actions -->

    <div class="card shadow mb-4">

        <div class="card-header bg-primary text-white">

            Quick Actions

        </div>

        <div class="card-body">

            <a href="generate_result.php" class="btn btn-success me-2">
                <i class="fas fa-calculator"></i>
                Generate Result
            </a>

            <a href="save_result.php" class="btn btn-primary me-2">
                <i class="fas fa-save"></i>
                Save Result
            </a>

            <a href="marksheet.php" class="btn btn-warning me-2">
                <i class="fas fa-file-alt"></i>
                Marksheet
            </a>

            <a href="result_list.php" class="btn btn-info me-2">
                <i class="fas fa-list"></i>
                Result List
            </a>

            <a href="export_pdf.php" class="btn btn-danger">
                <i class="fas fa-file-pdf"></i>
                Export PDF
            </a>

        </div>

    </div>

    <!-- Recent Results -->

    <div class="card shadow">

        <div class="card-header bg-dark text-white">

            Recent Results

        </div>

        <div class="card-body">

            <table class="table table-bordered table-hover">

                <thead class="table-primary">

                    <tr>

                        <th>ID</th>
                        <th>Student Name</th>
                        <th>Roll No</th>
                        <th>Department</th>
                        <th>Percentage</th>
                        <th>Grade</th>
                        <th>Status</th>

                    </tr>

                </thead>

                <tbody>

                    <tr>

                        <td>1</td>
                        <td>Rahul Sharma</td>
                        <td>CS001</td>
                        <td>Computer</td>
                        <td>88%</td>
                        <td>A</td>
                        <td><span class="badge bg-success">PASS</span></td>

                    </tr>

                    <tr>

                        <td>2</td>
                        <td>Priya Patil</td>
                        <td>IT002</td>
                        <td>IT</td>
                        <td>92%</td>
                        <td>A+</td>
                        <td><span class="badge bg-success">PASS</span></td>

                    </tr>

                    <tr>

                        <td>3</td>
                        <td>Amit Kumar</td>
                        <td>AI003</td>
                        <td>AIML</td>
                        <td>35%</td>
                        <td>F</td>
                        <td><span class="badge bg-danger">FAIL</span></td>

                    </tr>

                </tbody>

            </table>

        </div>

    </div>

</div>

<?php

require_once("../../includes/footer.php");

?>