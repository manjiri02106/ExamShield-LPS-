<?php

$pageTitle = "Department Reports";

require_once("../../includes/header.php");

?>

<div class="container-fluid mt-4">

    <div class="row mb-4">

        <div class="col-md-12">

            <h2>
                <i class="fas fa-building text-primary"></i>
                Department Reports Dashboard
            </h2>

            <p class="text-muted">
                View and manage department-wise reports.
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

                    <h5>Passed</h5>

                    <h2>210</h2>

                </div>

            </div>

        </div>

        <div class="col-md-3 mb-4">

            <div class="card shadow border-0">

                <div class="card-body text-center">

                    <i class="fas fa-times-circle fa-3x text-danger mb-3"></i>

                    <h5>Failed</h5>

                    <h2>40</h2>

                </div>

            </div>

        </div>

        <div class="col-md-3 mb-4">

            <div class="card shadow border-0">

                <div class="card-body text-center">

                    <i class="fas fa-chart-pie fa-3x text-warning mb-3"></i>

                    <h5>Pass Percentage</h5>

                    <h2>84%</h2>

                </div>

            </div>

        </div>

    </div>

    <!-- Quick Actions -->

    <div class="row">

        <div class="col-md-6 mb-4">

            <div class="card shadow">

                <div class="card-header bg-primary text-white">

                    Reports

                </div>

                <div class="card-body">

                    <p>Generate department-wise reports.</p>

                    <a href="department_report.php" class="btn btn-primary">
                        View Department Report
                    </a>

                </div>

            </div>

        </div>

        <div class="col-md-6 mb-4">

            <div class="card shadow">

                <div class="card-header bg-danger text-white">

                    Failed Students

                </div>

                <div class="card-body">

                    <p>View department-wise failed students.</p>

                    <a href="failed_students.php" class="btn btn-danger">
                        View Failed Students
                    </a>

                </div>

            </div>

        </div>

    </div>

    <!-- Recent Reports -->

    <div class="card shadow">

        <div class="card-header bg-dark text-white">

            Recent Department Reports

        </div>

        <div class="card-body">

            <table class="table table-bordered table-hover">

                <thead class="table-primary">

                    <tr>

                        <th>ID</th>
                        <th>Department</th>
                        <th>Total Students</th>
                        <th>Pass</th>
                        <th>Fail</th>
                        <th>Pass %</th>

                    </tr>

                </thead>

                <tbody>

                    <tr>
                        <td>1</td>
                        <td>Computer</td>
                        <td>80</td>
                        <td>72</td>
                        <td>8</td>
                        <td>90%</td>
                    </tr>

                    <tr>
                        <td>2</td>
                        <td>IT</td>
                        <td>60</td>
                        <td>52</td>
                        <td>8</td>
                        <td>86.7%</td>
                    </tr>

                    <tr>
                        <td>3</td>
                        <td>AIML</td>
                        <td>50</td>
                        <td>40</td>
                        <td>10</td>
                        <td>80%</td>
                    </tr>

                    <tr>
                        <td>4</td>
                        <td>ENTC</td>
                        <td>60</td>
                        <td>46</td>
                        <td>14</td>
                        <td>76.7%</td>
                    </tr>

                </tbody>

            </table>

        </div>

    </div>

</div>

<?php

require_once("../../includes/footer.php");

?>