<?php

$pageTitle = "Automatic Evaluation";

require_once("../../includes/header.php");

?>

<div class="container-fluid mt-4">

    <div class="row">

        <div class="col-12">

            <h2 class="mb-4">
                <i class="fas fa-check-circle text-success"></i>
                Automatic Evaluation
            </h2>

        </div>

    </div>

    <!-- Dashboard Cards -->

    <div class="row">

        <div class="col-md-4 mb-4">

            <div class="card shadow border-0">

                <div class="card-body text-center">

                    <i class="fas fa-check-double fa-3x text-primary mb-3"></i>

                    <h5>Total Evaluations</h5>

                    <h2>125</h2>

                </div>

            </div>

        </div>

        <div class="col-md-4 mb-4">

            <div class="card shadow border-0">

                <div class="card-body text-center">

                    <i class="fas fa-user-check fa-3x text-success mb-3"></i>

                    <h5>Passed Students</h5>

                    <h2>100</h2>

                </div>

            </div>

        </div>

        <div class="col-md-4 mb-4">

            <div class="card shadow border-0">

                <div class="card-body text-center">

                    <i class="fas fa-user-times fa-3x text-danger mb-3"></i>

                    <h5>Failed Students</h5>

                    <h2>25</h2>

                </div>

            </div>

        </div>

    </div>

    <!-- Quick Actions -->

    <div class="row">

        <div class="col-md-6 mb-4">

            <div class="card shadow">

                <div class="card-header bg-primary text-white">

                    Automatic Evaluation

                </div>

                <div class="card-body">

                    <p>
                        Evaluate student marks automatically and generate results.
                    </p>

                    <a href="evaluate.php" class="btn btn-primary">
                        Start Evaluation
                    </a>

                </div>

            </div>

        </div>

        <div class="col-md-6 mb-4">

            <div class="card shadow">

                <div class="card-header bg-success text-white">

                    Answer Key

                </div>

                <div class="card-body">

                    <p>
                        Manage answer keys for automatic evaluation.
                    </p>

                    <a href="answer_key.php" class="btn btn-success">
                        View Answer Keys
                    </a>

                </div>

            </div>

        </div>

    </div>

    <!-- Recent Evaluations -->

    <div class="card shadow">

        <div class="card-header bg-dark text-white">

            Recent Evaluations

        </div>

        <div class="card-body">

            <table class="table table-bordered table-hover">

                <thead class="table-primary">

                    <tr>

                        <th>ID</th>
                        <th>Student</th>
                        <th>Department</th>
                        <th>Exam</th>
                        <th>Percentage</th>
                        <th>Status</th>

                    </tr>

                </thead>

                <tbody>

                    <tr>

                        <td>1</td>
                        <td>Rahul Sharma</td>
                        <td>Computer</td>
                        <td>PHP Test</td>
                        <td>88%</td>
                        <td><span class="badge bg-success">Pass</span></td>

                    </tr>

                    <tr>

                        <td>2</td>
                        <td>Priya Patil</td>
                        <td>IT</td>
                        <td>Java Test</td>
                        <td>74%</td>
                        <td><span class="badge bg-success">Pass</span></td>

                    </tr>

                    <tr>

                        <td>3</td>
                        <td>Amit Kumar</td>
                        <td>AIML</td>
                        <td>Database</td>
                        <td>32%</td>
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