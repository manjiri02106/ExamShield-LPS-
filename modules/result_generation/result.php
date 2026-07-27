<?php

$pageTitle = "Student Result";

require_once("../../includes/header.php");
require_once("../../config/database.php");

?>

<div class="container-fluid mt-4">

    <div class="row mb-4">

        <div class="col-md-12">

            <h2>
                <i class="fas fa-graduation-cap text-success"></i>
                Student Result
            </h2>

        </div>

    </div>

    <!-- Search Result -->

    <div class="card shadow mb-4">

        <div class="card-header bg-primary text-white">

            Search Student Result

        </div>

        <div class="card-body">

            <form method="GET">

                <div class="row">

                    <div class="col-md-4">

                        <label>Roll Number</label>

                        <input type="text"
                               name="roll"
                               class="form-control"
                               placeholder="Enter Roll Number"
                               required>

                    </div>

                    <div class="col-md-4">

                        <label>Exam Name</label>

                        <input type="text"
                               name="exam"
                               class="form-control"
                               placeholder="Enter Exam Name">

                    </div>

                    <div class="col-md-4 d-flex align-items-end">

                        <button class="btn btn-success w-100">

                            Search Result

                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>

    <!-- Student Information -->

    <div class="card shadow mb-4">

        <div class="card-header bg-info text-white">

            Student Information

        </div>

        <div class="card-body">

            <table class="table table-bordered">

                <tr>
                    <th>Name</th>
                    <td>Rahul Sharma</td>
                </tr>

                <tr>
                    <th>Roll No</th>
                    <td>CS001</td>
                </tr>

                <tr>
                    <th>Department</th>
                    <td>Computer Engineering</td>
                </tr>

                <tr>
                    <th>Semester</th>
                    <td>Semester 5</td>
                </tr>

            </table>

        </div>

    </div>

    <!-- Result Table -->

    <div class="card shadow">

        <div class="card-header bg-dark text-white">

            Subject Wise Result

        </div>

        <div class="card-body">

            <table class="table table-bordered table-hover">

                <thead class="table-primary">

                    <tr>

                        <th>Subject</th>
                        <th>Total Marks</th>
                        <th>Obtained</th>
                        <th>Grade</th>
                        <th>Status</th>

                    </tr>

                </thead>

                <tbody>

                    <tr>

                        <td>PHP</td>
                        <td>100</td>
                        <td>90</td>
                        <td>A+</td>
                        <td>
                            <span class="badge bg-success">
                                PASS
                            </span>
                        </td>

                    </tr>

                    <tr>

                        <td>Java</td>
                        <td>100</td>
                        <td>85</td>
                        <td>A</td>
                        <td>
                            <span class="badge bg-success">
                                PASS
                            </span>
                        </td>

                    </tr>

                    <tr>

                        <td>Database</td>
                        <td>100</td>
                        <td>88</td>
                        <td>A+</td>
                        <td>
                            <span class="badge bg-success">
                                PASS
                            </span>
                        </td>

                    </tr>

                    <tr>

                        <td>CSS</td>
                        <td>100</td>
                        <td>82</td>
                        <td>A</td>
                        <td>
                            <span class="badge bg-success">
                                PASS
                            </span>
                        </td>

                    </tr>

                    <tr>

                        <td>JavaScript</td>
                        <td>100</td>
                        <td>79</td>
                        <td>B+</td>
                        <td>
                            <span class="badge bg-success">
                                PASS
                            </span>
                        </td>

                    </tr>

                </tbody>

            </table>

        </div>

    </div>

    <!-- Summary -->

    <div class="row mt-4">

        <div class="col-md-3">

            <div class="card border-primary">

                <div class="card-body text-center">

                    <h5>Total Marks</h5>

                    <h3>500</h3>

                </div>

            </div>

        </div>

        <div class="col-md-3">

            <div class="card border-success">

                <div class="card-body text-center">

                    <h5>Obtained</h5>

                    <h3>424</h3>

                </div>

            </div>

        </div>

        <div class="col-md-3">

            <div class="card border-warning">

                <div class="card-body text-center">

                    <h5>Percentage</h5>

                    <h3>84.80%</h3>

                </div>

            </div>

        </div>

        <div class="col-md-3">

            <div class="card border-danger">

                <div class="card-body text-center">

                    <h5>Final Result</h5>

                    <h3 class="text-success">

                        PASS

                    </h3>

                </div>

            </div>

        </div>

    </div>

    <div class="mt-4">

        <a href="marksheet.php" class="btn btn-primary">

            <i class="fas fa-file-alt"></i>

            View Marksheet

        </a>

        <a href="export_pdf.php" class="btn btn-danger">

            <i class="fas fa-file-pdf"></i>

            Export PDF

        </a>

    </div>

</div>

<?php

require_once("../../includes/footer.php");

?>