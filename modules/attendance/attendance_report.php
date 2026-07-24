<?php

$pageTitle = "Attendance Report";

require_once("../../includes/header.php");

?>

<div class="container-fluid mt-4">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h2>
            <i class="fas fa-file-alt"></i>
            Attendance Report
        </h2>

        <button class="btn btn-success" onclick="printAttendance()">
            <i class="fas fa-print"></i> Print Report
        </button>

    </div>

    <!-- Filter Section -->

    <div class="card shadow mb-4">

        <div class="card-header bg-primary text-white">

            Filter Attendance Report

        </div>

        <div class="card-body">

            <div class="row">

                <div class="col-md-3 mb-3">

                    <label>Department</label>

                    <select class="form-select" id="departmentFilter">

                        <option value="All">All Departments</option>
                        <option value="Computer">Computer</option>
                        <option value="IT">IT</option>
                        <option value="AIML">AIML</option>
                        <option value="ENTC">ENTC</option>

                    </select>

                </div>

                <div class="col-md-3 mb-3">

                    <label>Status</label>

                    <select class="form-select" id="statusFilter">

                        <option value="All">All</option>
                        <option value="Present">Present</option>
                        <option value="Absent">Absent</option>

                    </select>

                </div>

                <div class="col-md-3 mb-3">

                    <label>Date</label>

                    <input type="date" class="form-control">

                </div>

                <div class="col-md-3 mb-3 d-flex align-items-end">

                    <button class="btn btn-primary w-100"
                            onclick="filterAttendance()">

                        Apply Filter

                    </button>

                </div>

            </div>

        </div>

    </div>

    <!-- Attendance Summary -->

    <div class="row mb-4">

        <div class="col-md-4">

            <div class="card shadow border-0">

                <div class="card-body text-center">

                    <h6>Total Students</h6>

                    <h2 class="text-primary">250</h2>

                </div>

            </div>

        </div>

        <div class="col-md-4">

            <div class="card shadow border-0">

                <div class="card-body text-center">

                    <h6>Present</h6>

                    <h2 class="text-success">230</h2>

                </div>

            </div>

        </div>

        <div class="col-md-4">

            <div class="card shadow border-0">

                <div class="card-body text-center">

                    <h6>Absent</h6>

                    <h2 class="text-danger">20</h2>

                </div>

            </div>

        </div>

    </div>

    <!-- Attendance Table -->

    <div class="card shadow">

        <div class="card-header bg-dark text-white">

            Attendance Details

        </div>

        <div class="card-body">

            <table class="table table-bordered table-hover" id="attendanceTable">

                <thead class="table-primary">

                    <tr>

                        <th>ID</th>
                        <th>Student Name</th>
                        <th>Department</th>
                        <th>Date</th>
                        <th>Status</th>

                    </tr>

                </thead>

                <tbody>

                    <tr data-department="Computer" data-status="Present">

                        <td>1</td>
                        <td>Rahul Sharma</td>
                        <td>Computer</td>
                        <td>22-07-2026</td>
                        <td>
                            <span class="badge bg-success">
                                Present
                            </span>
                        </td>

                    </tr>

                    <tr data-department="IT" data-status="Absent">

                        <td>2</td>
                        <td>Priya Patil</td>
                        <td>IT</td>
                        <td>22-07-2026</td>
                        <td>
                            <span class="badge bg-danger">
                                Absent
                            </span>
                        </td>

                    </tr>

                    <tr data-department="AIML" data-status="Present">

                        <td>3</td>
                        <td>Amit Kumar</td>
                        <td>AIML</td>
                        <td>22-07-2026</td>
                        <td>
                            <span class="badge bg-success">
                                Present
                            </span>
                        </td>

                    </tr>

                    <tr data-department="ENTC" data-status="Present">

                        <td>4</td>
                        <td>Sneha Joshi</td>
                        <td>ENTC</td>
                        <td>22-07-2026</td>
                        <td>
                            <span class="badge bg-success">
                                Present
                            </span>
                        </td>

                    </tr>

                </tbody>

            </table>

        </div>

    </div>

    <div class="mt-4">

        <button class="btn btn-success" onclick="exportAttendance()">

            <i class="fas fa-file-excel"></i>

            Export Report

        </button>

    </div>

</div>

<?php

require_once("../../includes/footer.php");

?>