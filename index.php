<?php
/**
 * ==========================================
 * ExamShield LPS - Primary Dashboard
 * ==========================================
 */

$pageTitle = "ExamShield LPS - Result & Analytics System";

require_once(__DIR__ . '/includes/header.php');
require_once(__DIR__ . '/config/database.php');

// Fetch Dynamic Statistics from Database
$totalStudents = 0;
$passStudents = 0;
$failStudents = 0;
$passPercentage = 0;

if (isset($conn) && $conn) {
    $resSt = mysqli_query($conn, "SELECT COUNT(*) as count FROM students");
    if ($resSt) {
        $totalStudents = mysqli_fetch_assoc($resSt)['count'];
    }

    $resPass = mysqli_query($conn, "SELECT COUNT(*) as count FROM results WHERE status = 'Pass'");
    if ($resPass) {
        $passStudents = mysqli_fetch_assoc($resPass)['count'];
    }

    $resFail = mysqli_query($conn, "SELECT COUNT(*) as count FROM results WHERE status = 'Fail'");
    if ($resFail) {
        $failStudents = mysqli_fetch_assoc($resFail)['count'];
    }

    $totalResults = $passStudents + $failStudents;
    if ($totalResults > 0) {
        $passPercentage = round(($passStudents / $totalResults) * 100, 1);
    }
}
?>

<div class="container-fluid mt-4">

    <div class="row mb-4">
        <div class="col-md-12">
            <h2>
                <i class="fas fa-graduation-cap text-primary me-2"></i>
                ExamShield LPS - Student Result Management System
            </h2>
            <p class="text-muted">
                Access automated evaluation, result generation, marks management, attendance reports, department analytics, and export tools.
            </p>
        </div>
    </div>

    <!-- Dashboard Metric Cards -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card shadow-sm border-0 border-start border-4 border-primary">
                <div class="card-body text-center">
                    <i class="fas fa-users fa-3x text-primary mb-3"></i>
                    <h5 class="text-muted small text-uppercase">Total Students</h5>
                    <h2 class="fw-bold text-dark"><?php echo number_format($totalStudents); ?></h2>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card shadow-sm border-0 border-start border-4 border-success">
                <div class="card-body text-center">
                    <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                    <h5 class="text-muted small text-uppercase">Pass Students</h5>
                    <h2 class="fw-bold text-success"><?php echo number_format($passStudents); ?></h2>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card shadow-sm border-0 border-start border-4 border-danger">
                <div class="card-body text-center">
                    <i class="fas fa-times-circle fa-3x text-danger mb-3"></i>
                    <h5 class="text-muted small text-uppercase">Failed Students</h5>
                    <h2 class="fw-bold text-danger"><?php echo number_format($failStudents); ?></h2>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card shadow-sm border-0 border-start border-4 border-warning">
                <div class="card-body text-center">
                    <i class="fas fa-chart-line fa-3x text-warning mb-3"></i>
                    <h5 class="text-muted small text-uppercase">Pass Percentage</h5>
                    <h2 class="fw-bold text-dark"><?php echo $passPercentage; ?>%</h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Access Module Cards -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-primary text-white fw-bold">
            <i class="fas fa-th me-2"></i> Quick Module Navigation
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-6 col-md-4 col-lg-2">
                    <a href="modules/results/automatic_evaluation.php" class="btn btn-outline-primary w-100 p-3 text-center">
                        <i class="fas fa-robot fa-2x mb-2 d-block text-primary"></i>
                        <small class="fw-bold">Automatic Evaluation</small>
                    </a>
                </div>
                <div class="col-6 col-md-4 col-lg-2">
                    <a href="modules/results/generate_result.php" class="btn btn-outline-success w-100 p-3 text-center">
                        <i class="fas fa-file-invoice fa-2x mb-2 d-block text-success"></i>
                        <small class="fw-bold">Result Generation</small>
                    </a>
                </div>
                <div class="col-6 col-md-4 col-lg-2">
                    <a href="modules/results/marks.php" class="btn btn-outline-warning w-100 p-3 text-center">
                        <i class="fas fa-edit fa-2x mb-2 d-block text-warning"></i>
                        <small class="fw-bold">Marks Management</small>
                    </a>
                </div>
                <div class="col-6 col-md-4 col-lg-2">
                    <a href="modules/results/attendance_report.php" class="btn btn-outline-info w-100 p-3 text-center">
                        <i class="fas fa-user-check fa-2x mb-2 d-block text-info"></i>
                        <small class="fw-bold">Attendance Report</small>
                    </a>
                </div>
                <div class="col-6 col-md-4 col-lg-2">
                    <a href="modules/results/department_report.php" class="btn btn-outline-secondary w-100 p-3 text-center">
                        <i class="fas fa-building fa-2x mb-2 d-block text-secondary"></i>
                        <small class="fw-bold">Department Reports</small>
                    </a>
                </div>
                <div class="col-6 col-md-4 col-lg-2">
                    <a href="modules/results/analytics_dashboard.php" class="btn btn-outline-dark w-100 p-3 text-center">
                        <i class="fas fa-chart-pie fa-2x mb-2 d-block text-dark"></i>
                        <small class="fw-bold">Analytics Dashboard</small>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- System Overview & Recent Results Table -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-dark text-white fw-bold d-flex justify-content-between align-items-center">
            <span><i class="fas fa-history me-2"></i> Recently Evaluated Results</span>
            <a href="modules/results/generate_result.php" class="btn btn-sm btn-light">View All Results</a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Student Name</th>
                            <th>Roll / Enrollment No</th>
                            <th>Department</th>
                            <th>Percentage</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (isset($conn) && $conn) {
                            $resRecent = mysqli_query($conn, "
                                SELECT r.result_id, r.percentage, r.status, s.student_name, s.roll_no, d.department_name
                                FROM results r
                                JOIN students s ON r.student_id = s.student_id
                                JOIN departments d ON s.department_id = d.department_id
                                ORDER BY r.result_id DESC
                                LIMIT 5
                            ");
                            if ($resRecent && mysqli_num_rows($resRecent) > 0) {
                                while ($row = mysqli_fetch_assoc($resRecent)) {
                                    echo "<tr>";
                                    echo "<td class='fw-bold'>" . htmlspecialchars($row['student_name']) . "</td>";
                                    echo "<td><code>" . htmlspecialchars($row['roll_no']) . "</code></td>";
                                    echo "<td>" . htmlspecialchars($row['department_name']) . "</td>";
                                    echo "<td class='fw-bold text-primary'>" . number_format($row['percentage'], 2) . "%</td>";
                                    if ($row['status'] === 'Pass') {
                                        echo "<td><span class='badge bg-success-subtle text-success border border-success px-3 py-1 rounded-pill'>PASS</span></td>";
                                    } else {
                                        echo "<td><span class='badge bg-danger-subtle text-danger border border-danger px-3 py-1 rounded-pill'>FAIL</span></td>";
                                    }
                                    echo "<td><a href='modules/results/marksheet.php?id={$row['result_id']}' class='btn btn-sm btn-outline-primary'><i class='fas fa-eye me-1'></i> Marksheet</a></td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='6' class='text-center py-4 text-muted'>No recent result records found.</td></tr>";
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<?php
require_once(__DIR__ . '/includes/footer.php');
?>