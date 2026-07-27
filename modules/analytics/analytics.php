<?php

$pageTitle = "Analytics Dashboard";

require_once("../../includes/header.php");

?>

<div class="container-fluid mt-4">

    <h2 class="mb-4 text-primary">
        <i class="fas fa-chart-line"></i>
        Analytics Dashboard
    </h2>

    <!-- Statistics Cards -->
    <div class="row">

        <div class="col-md-3 mb-4">
            <div class="card shadow border-0">
                <div class="card-body text-center">
                    <h6>Total Students</h6>
                    <h2 class="text-primary">2350</h2>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card shadow border-0">
                <div class="card-body text-center">
                    <h6>Total Exams</h6>
                    <h2 class="text-success">48</h2>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card shadow border-0">
                <div class="card-body text-center">
                    <h6>Average Score</h6>
                    <h2 class="text-warning">72%</h2>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card shadow border-0">
                <div class="card-body text-center">
                    <h6>Pass Percentage</h6>
                    <h2 class="text-danger">85%</h2>
                </div>
            </div>
        </div>

    </div>

    <!-- Charts -->
    <div class="row">

        <div class="col-md-8 mb-4">

            <div class="card shadow">

                <div class="card-header bg-primary text-white">
                    Student Performance
                </div>

                <div class="card-body">
                    <canvas id="lineChart"></canvas>
                </div>

            </div>

        </div>

        <div class="col-md-4 mb-4">

            <div class="card shadow">

                <div class="card-header bg-success text-white">
                    Result Distribution
                </div>

                <div class="card-body">
                    <canvas id="pieChart"></canvas>
                </div>

            </div>

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

                        <th>Student</th>
                        <th>Department</th>
                        <th>Exam</th>
                        <th>Marks</th>
                        <th>Result</th>

                    </tr>

                </thead>

                <tbody>

                    <tr>
                        <td>Rahul Sharma</td>
                        <td>Computer</td>
                        <td>PHP Test</td>
                        <td>88</td>
                        <td><span class="badge bg-success">Pass</span></td>
                    </tr>

                    <tr>
                        <td>Priya Patil</td>
                        <td>IT</td>
                        <td>Java Test</td>
                        <td>74</td>
                        <td><span class="badge bg-success">Pass</span></td>
                    </tr>

                    <tr>
                        <td>Amit Kumar</td>
                        <td>AIML</td>
                        <td>Database</td>
                        <td>32</td>
                        <td><span class="badge bg-danger">Fail</span></td>
                    </tr>

                </tbody>

            </table>

        </div>

    </div>

</div>

<?php

require_once("../../includes/footer.php");

?>