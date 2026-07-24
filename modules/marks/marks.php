<?php

$pageTitle = "Marks Management";

require_once("../../includes/header.php");
require_once("../../config/database.php");

?>

<div class="container-fluid mt-4">

    <div class="row mb-4">

        <div class="col-md-12">

            <h2>
                <i class="fas fa-book text-primary"></i>
                Marks Management
            </h2>

            <p class="text-muted">
                Manage student marks and examination records.
            </p>

        </div>

    </div>

    <!-- Summary Cards -->

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

                    <i class="fas fa-file-alt fa-3x text-success mb-3"></i>

                    <h5>Total Subjects</h5>

                    <h2>8</h2>

                </div>

            </div>

        </div>

        <div class="col-md-3 mb-4">

            <div class="card shadow border-0">

                <div class="card-body text-center">

                    <i class="fas fa-chart-line fa-3x text-warning mb-3"></i>

                    <h5>Average Marks</h5>

                    <h2>72%</h2>

                </div>

            </div>

        </div>

        <div class="col-md-3 mb-4">

            <div class="card shadow border-0">

                <div class="card-body text-center">

                    <i class="fas fa-check-circle fa-3x text-info mb-3"></i>

                    <h5>Results</h5>

                    <h2>Completed</h2>

                </div>

            </div>

        </div>

    </div>

    <!-- Action Buttons -->

    <div class="card shadow mb-4">

        <div class="card-header bg-primary text-white">

            Quick Actions

        </div>

        <div class="card-body">

            <a href="add_marks.php" class="btn btn-success me-2">
                <i class="fas fa-plus"></i> Add Marks
            </a>

            <a href="marks_list.php" class="btn btn-info me-2">
                <i class="fas fa-list"></i> View Marks
            </a>

            <a href="calculate_marks.php" class="btn btn-warning me-2">
                <i class="fas fa-calculator"></i> Calculate Result
            </a>

        </div>

    </div>

    <!-- Sample Marks Table -->

    <div class="card shadow">

        <div class="card-header bg-dark text-white">

            Student Marks

        </div>

        <div class="card-body">

            <table class="table table-bordered table-hover">

                <thead class="table-primary">

                    <tr>

                        <th>ID</th>
                        <th>Student Name</th>
                        <th>Department</th>
                        <th>Subject</th>
                        <th>Marks</th>
                        <th>Total</th>
                        <th>Percentage</th>

                    </tr>

                </thead>

                <tbody>

                    <tr>

                        <td>1</td>
                        <td>Rahul Sharma</td>
                        <td>Computer</td>
                        <td>PHP</td>
                        <td>88</td>
                        <td>100</td>
                        <td>88%</td>

                    </tr>

                    <tr>

                        <td>2</td>
                        <td>Priya Patil</td>
                        <td>IT</td>
                        <td>Java</td>
                        <td>91</td>
                        <td>100</td>
                        <td>91%</td>

                    </tr>

                    <tr>

                        <td>3</td>
                        <td>Amit Kumar</td>
                        <td>AIML</td>
                        <td>Database</td>
                        <td>76</td>
                        <td>100</td>
                        <td>76%</td>

                    </tr>

                    <tr>

                        <td>4</td>
                        <td>Sneha Joshi</td>
                        <td>ENTC</td>
                        <td>Networks</td>
                        <td>84</td>
                        <td>100</td>
                        <td>84%</td>

                    </tr>

                </tbody>

            </table>

        </div>

    </div>

</div>

<?php

require_once("../../includes/footer.php");

?>