<?php

$pageTitle = "Topper Report";

require_once("../../includes/header.php");
require_once("../../config/database.php");

?>

<div class="container-fluid mt-4">

    <div class="row mb-4">

        <div class="col-md-12">

            <h2>
                <i class="fas fa-trophy text-warning"></i>
                Department Topper Report
            </h2>

        </div>

    </div>

    <!-- Summary Cards -->

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

                    <i class="fas fa-medal fa-3x text-success mb-3"></i>

                    <h5>Total Toppers</h5>

                    <h2>4</h2>

                </div>

            </div>

        </div>

        <div class="col-md-3 mb-4">

            <div class="card shadow border-0">

                <div class="card-body text-center">

                    <i class="fas fa-star fa-3x text-warning mb-3"></i>

                    <h5>Highest Marks</h5>

                    <h2>98%</h2>

                </div>

            </div>

        </div>

        <div class="col-md-3 mb-4">

            <div class="card shadow border-0">

                <div class="card-body text-center">

                    <i class="fas fa-building fa-3x text-info mb-3"></i>

                    <h5>Departments</h5>

                    <h2>4</h2>

                </div>

            </div>

        </div>

    </div>

    <!-- Filter -->

    <div class="card shadow mb-4">

        <div class="card-header bg-primary text-white">

            Filter Topper Report

        </div>

        <div class="card-body">

            <form method="GET">

                <div class="row">

                    <div class="col-md-4">

                        <label>Department</label>

                        <select class="form-select" name="department">

                            <option value="">All Departments</option>
                            <option>Computer</option>
                            <option>IT</option>
                            <option>AIML</option>
                            <option>ENTC</option>

                        </select>

                    </div>

                    <div class="col-md-4">

                        <label>Exam Name</label>

                        <input type="text"
                               name="exam"
                               class="form-control"
                               placeholder="Enter Exam Name">

                    </div>

                    <div class="col-md-4 d-flex align-items-end">

                        <button class="btn btn-primary w-100">

                            Search

                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>

    <!-- Topper Table -->

    <div class="card shadow">

        <div class="card-header bg-success text-white">

            Department Wise Toppers

        </div>

        <div class="card-body">

            <table class="table table-bordered table-hover">

                <thead class="table-success">

                    <tr>

                        <th>Rank</th>
                        <th>Student Name</th>
                        <th>Department</th>
                        <th>Exam</th>
                        <th>Marks</th>
                        <th>Percentage</th>
                        <th>Grade</th>

                    </tr>

                </thead>

                <tbody>

                    <tr>

                        <td>1</td>
                        <td>Rahul Sharma</td>
                        <td>Computer</td>
                        <td>PHP Exam</td>
                        <td>98</td>
                        <td>98%</td>
                        <td><span class="badge bg-success">A+</span></td>

                    </tr>

                    <tr>

                        <td>2</td>
                        <td>Priya Patil</td>
                        <td>IT</td>
                        <td>Java Exam</td>
                        <td>96</td>
                        <td>96%</td>
                        <td><span class="badge bg-success">A+</span></td>

                    </tr>

                    <tr>

                        <td>3</td>
                        <td>Sneha Joshi</td>
                        <td>AIML</td>
                        <td>Database</td>
                        <td>95</td>
                        <td>95%</td>
                        <td><span class="badge bg-success">A+</span></td>

                    </tr>

                    <tr>

                        <td>4</td>
                        <td>Rohan Patil</td>
                        <td>ENTC</td>
                        <td>Networks</td>
                        <td>94</td>
                        <td>94%</td>
                        <td><span class="badge bg-success">A+</span></td>

                    </tr>

                </tbody>

            </table>

        </div>

    </div>

    <br>

    <button class="btn btn-success">

        <i class="fas fa-file-excel"></i>
        Export Excel

    </button>

    <button class="btn btn-danger">

        <i class="fas fa-file-pdf"></i>
        Export PDF

    </button>

</div>

<?php

require_once("../../includes/footer.php");

?>