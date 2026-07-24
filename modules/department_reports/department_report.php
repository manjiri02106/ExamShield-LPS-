<?php

$pageTitle = "Department Report";

require_once("../../includes/header.php");
require_once("../../config/database.php");

?>

<div class="container-fluid mt-4">

    <div class="row mb-4">

        <div class="col-md-12">

            <h2>
                <i class="fas fa-building"></i>
                Department Report
            </h2>

        </div>

    </div>

    <!-- Filter -->

    <div class="card shadow mb-4">

        <div class="card-header bg-primary text-white">

            Filter Report

        </div>

        <div class="card-body">

            <form method="GET">

                <div class="row">

                    <div class="col-md-4">

                        <label>Department</label>

                        <select class="form-select" name="department">

                            <option value="">All Departments</option>
                            <option value="Computer">Computer</option>
                            <option value="IT">IT</option>
                            <option value="AIML">AIML</option>
                            <option value="ENTC">ENTC</option>

                        </select>

                    </div>

                    <div class="col-md-4">

                        <label>Exam</label>

                        <input type="text"
                               name="exam"
                               class="form-control"
                               placeholder="Exam Name">

                    </div>

                    <div class="col-md-4 d-flex align-items-end">

                        <button class="btn btn-primary w-100">

                            Generate Report

                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>

    <!-- Summary Cards -->

    <div class="row">

        <div class="col-md-3">

            <div class="card shadow text-center">

                <div class="card-body">

                    <h6>Total Students</h6>

                    <h2 class="text-primary">250</h2>

                </div>

            </div>

        </div>

        <div class="col-md-3">

            <div class="card shadow text-center">

                <div class="card-body">

                    <h6>Passed</h6>

                    <h2 class="text-success">210</h2>

                </div>

            </div>

        </div>

        <div class="col-md-3">

            <div class="card shadow text-center">

                <div class="card-body">

                    <h6>Failed</h6>

                    <h2 class="text-danger">40</h2>

                </div>

            </div>

        </div>

        <div class="col-md-3">

            <div class="card shadow text-center">

                <div class="card-body">

                    <h6>Pass %</h6>

                    <h2 class="text-success">84%</h2>

                </div>

            </div>

        </div>

    </div>

    <br>

    <!-- Report Table -->

    <div class="card shadow">

        <div class="card-header bg-dark text-white">

            Department Result Report

        </div>

        <div class="card-body">

            <table class="table table-bordered table-hover">

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
                        <td>PHP Exam</td>
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
                        <td>Java Exam</td>
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