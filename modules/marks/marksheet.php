<?php

$pageTitle = "Student Marksheet";

require_once("../../includes/header.php");
require_once("../../config/database.php");

?>

<div class="container-fluid mt-4">

    <div class="card shadow">

        <div class="card-header bg-primary text-white">

            <h3>
                <i class="fas fa-file-alt"></i>
                Student Marksheet
            </h3>

        </div>

        <div class="card-body">

            <!-- Student Details -->

            <div class="row mb-4">

                <div class="col-md-6">

                    <table class="table table-bordered">

                        <tr>
                            <th>Student Name</th>
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

                    </table>

                </div>

                <div class="col-md-6">

                    <table class="table table-bordered">

                        <tr>
                            <th>Semester</th>
                            <td>Semester 5</td>
                        </tr>

                        <tr>
                            <th>Academic Year</th>
                            <td>2026-27</td>
                        </tr>

                        <tr>
                            <th>Exam</th>
                            <td>End Semester</td>
                        </tr>

                    </table>

                </div>

            </div>

            <!-- Marks Table -->

            <table class="table table-bordered table-hover">

                <thead class="table-dark">

                    <tr>

                        <th>Subject</th>
                        <th>Total Marks</th>
                        <th>Obtained Marks</th>
                        <th>Grade</th>
                        <th>Status</th>

                    </tr>

                </thead>

                <tbody>

                    <tr>

                        <td>PHP Programming</td>
                        <td>100</td>
                        <td>90</td>
                        <td>A+</td>
                        <td>
                            <span class="badge bg-success">
                                Pass
                            </span>
                        </td>

                    </tr>

                    <tr>

                        <td>Java Programming</td>
                        <td>100</td>
                        <td>85</td>
                        <td>A</td>
                        <td>
                            <span class="badge bg-success">
                                Pass
                            </span>
                        </td>

                    </tr>

                    <tr>

                        <td>Database Management</td>
                        <td>100</td>
                        <td>88</td>
                        <td>A+</td>
                        <td>
                            <span class="badge bg-success">
                                Pass
                            </span>
                        </td>

                    </tr>

                    <tr>

                        <td>Web Technology</td>
                        <td>100</td>
                        <td>79</td>
                        <td>B+</td>
                        <td>
                            <span class="badge bg-success">
                                Pass
                            </span>
                        </td>

                    </tr>

                    <tr>

                        <td>Software Engineering</td>
                        <td>100</td>
                        <td>82</td>
                        <td>A</td>
                        <td>
                            <span class="badge bg-success">
                                Pass
                            </span>
                        </td>

                    </tr>

                </tbody>

            </table>

            <!-- Result Summary -->

            <div class="row mt-4">

                <div class="col-md-4">

                    <div class="card border-success">

                        <div class="card-body text-center">

                            <h5>Total Marks</h5>

                            <h3>500</h3>

                        </div>

                    </div>

                </div>

                <div class="col-md-4">

                    <div class="card border-primary">

                        <div class="card-body text-center">

                            <h5>Obtained Marks</h5>

                            <h3>424</h3>

                        </div>

                    </div>

                </div>

                <div class="col-md-4">

                    <div class="card border-warning">

                        <div class="card-body text-center">

                            <h5>Percentage</h5>

                            <h3>84.80%</h3>

                        </div>

                    </div>

                </div>

            </div>

            <div class="alert alert-success mt-4 text-center">

                <h4>Final Result : PASS</h4>

            </div>

            <div class="text-center mt-4">

                <button onclick="window.print()" class="btn btn-primary">

                    <i class="fas fa-print"></i>
                    Print Marksheet

                </button>

                <button class="btn btn-success">

                    <i class="fas fa-download"></i>
                    Download PDF

                </button>

            </div>

        </div>

    </div>

</div>

<?php

require_once("../../includes/footer.php");

?>