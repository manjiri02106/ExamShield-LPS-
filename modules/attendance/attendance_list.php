<?php

$pageTitle = "Attendance List";

require_once("../../includes/header.php");

?>

<div class="container-fluid mt-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fas fa-calendar-check"></i> Attendance List</h2>

        <a href="attendance_report.php" class="btn btn-success">
            <i class="fas fa-file-pdf"></i> Attendance Report
        </a>
    </div>

    <!-- Search -->

    <div class="row mb-3">

        <div class="col-md-4">
            <input type="text"
                   id="searchAttendance"
                   class="form-control"
                   placeholder="Search Student...">
        </div>

        <div class="col-md-3">
            <select id="departmentFilter" class="form-select">
                <option value="All">All Departments</option>
                <option value="Computer">Computer</option>
                <option value="IT">IT</option>
                <option value="AIML">AIML</option>
                <option value="ENTC">ENTC</option>
            </select>
        </div>

        <div class="col-md-3">
            <select id="statusFilter" class="form-select">
                <option value="All">All Status</option>
                <option value="Present">Present</option>
                <option value="Absent">Absent</option>
            </select>
        </div>

        <div class="col-md-2">
            <button class="btn btn-primary w-100"
                    onclick="refreshAttendance()">
                Refresh
            </button>
        </div>

    </div>

    <!-- Attendance Table -->

    <div class="card shadow">

        <div class="card-header bg-primary text-white">

            Student Attendance

        </div>

        <div class="card-body">

            <table class="table table-bordered table-hover"
                   id="attendanceTable">

                <thead class="table-primary">

                <tr>

                    <th>ID</th>
                    <th>Name</th>
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

</div>

<?php

require_once("../../includes/footer.php");

?>
