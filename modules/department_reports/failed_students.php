<?php

$pageTitle = "Failed Students Report";

require_once("../../includes/header.php");
require_once("../../config/database.php");

?>

<div class="container-fluid mt-4">

    <div class="row mb-4">

        <div class="col-md-12">

            <h2>
                <i class="fas fa-user-times text-danger"></i>
                Failed Students Report
            </h2>

        </div>

    </div>

    <!-- Summary Cards -->

    <div class="row">

        <div class="col-md-3">

            <div class="card shadow text-center">

                <div class="card-body">

                    <h6>Total Failed Students</h6>

                    <h2 class="text-danger">40</h2>

                </div>

            </div>

        </div>

        <div class="col-md-3">

            <div class="card shadow text-center">

                <div class="card-body">

                    <h6>Computer</h6>

                    <h2 class="text-primary">12</h2>

                </div>

            </div>

        </div>

        <div class="col-md-3">

            <div class="card shadow text-center">

                <div class="card-body">

                    <h6>IT</h6>

                    <h2 class="text-success">10</h2>

                </div>

            </div>

        </div>

        <div class="col-md-3">

            <div class="card shadow text-center">

                <div class="card-body">

                    <h6>AIML</h6>

                    <h2 class="text-warning">18</h2>

                </div>

            </div>

        </div>

    </div>

    <br>

    <!-- Filter -->

    <div class="card shadow mb-4">

        <div class="card-header bg-primary text-white">

            Search Failed Students

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
                               class="form-control"
                               name="exam"
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

    <!-- Table -->

    <div class="card shadow">

        <div class="card-header bg-danger text-white">

            Failed Students List

        </div>

        <div class="card-body">

            <table class="table table-bordered table-hover">

                <thead class="table-dark">

                    <tr>

                        <th>ID</th>
                        <th>Student Name</th>
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
                        <td>Amit Kumar</td>
                        <td>AIML</td>
                        <td>Database</td>
                        <td>32</td>
                        <td>32%</td>
                        <td>
                            <span class="badge bg-danger">
                                FAIL
                            </span>
                        </td>

                    </tr>

                    <tr>

                        <td>2</td>
                        <td>Rohit Patil</td>
                        <td>Computer</td>
                        <td>PHP</td>
                        <td>28</td>
                        <td>28%</td>
                        <td>
                            <span class="badge bg-danger">
                                FAIL
                            </span>
                        </td>

                    </tr>

                    <tr>

                        <td>3</td>
                        <td>Sneha Joshi</td>
                        <td>IT</td>
                        <td>Java</td>
                        <td>35</td>
                        <td>35%</td>
                        <td>
                            <span class="badge bg-danger">
                                FAIL
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