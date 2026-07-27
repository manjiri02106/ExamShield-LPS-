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

        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card shadow border-0">
                <div class="card-body text-center">
                    <i class="fas fa-user-graduate fa-3x text-primary mb-3"></i>
                    <h6>Total Students</h6>
                    <h2>2350</h2>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card shadow border-0">
                <div class="card-body text-center">
                    <i class="fas fa-file-alt fa-3x text-success mb-3"></i>
                    <h6>Total Exams</h6>
                    <h2>48</h2>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card shadow border-0">
                <div class="card-body text-center">
                    <i class="fas fa-chart-bar fa-3x text-warning mb-3"></i>
                    <h6>Average Score</h6>
                    <h2>72%</h2>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card shadow border-0">
                <div class="card-body text-center">
                    <i class="fas fa-award fa-3x text-danger mb-3"></i>
                    <h6>Pass Percentage</h6>
                    <h2>85%</h2>
                </div>
            </div>
        </div>

    </div>

    <!-- Charts -->

    <div class="row">

        <div class="col-lg-8 mb-4">

            <div class="card shadow">

                <div class="card-header bg-primary text-white">

                    Student Performance

                </div>

                <div class="card-body">

                    <canvas id="lineChart" height="120"></canvas>

                </div>

            </div>

        </div>

        <div class="col-lg-4 mb-4">

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

            <table class="table table-striped table-hover">

                <thead class="table-primary">

                    <tr>

                        <th>ID</th>
                        <th>Student</th>
                        <th>Department</th>
                        <th>Exam</th>
                        <th>Marks</th>
                        <th>Percentage</th>
                        <th>Status</th>

                    </tr>

                </thead>

                <tbody>

                    <tr>

                        <td>1</td>
                        <td>Rahul Sharma</td>
                        <td>Computer</td>
                        <td>PHP</td>
                        <td>88</td>
                        <td>88%</td>
                        <td>
                            <span class="badge bg-success">
                                Pass
                            </span>
                        </td>

                    </tr>

                    <tr>

                        <td>2</td>
                        <td>Priya Patil</td>
                        <td>IT</td>
                        <td>Java</td>
                        <td>74</td>
                        <td>74%</td>
                        <td>
                            <span class="badge bg-success">
                                Pass
                            </span>
                        </td>

                    </tr>

                    <tr>

                        <td>3</td>
                        <td>Amit Kumar</td>
                        <td>AIML</td>
                        <td>Database</td>
                        <td>32</td>
                        <td>32%</td>
                        <td>
                            <span class="badge bg-danger">
                                Fail
                            </span>
                        </td>

                    </tr>

                </tbody>

            </table>

        </div>

    </div>

</div>

<?php

require_once("../../includes/footer.php");

?>