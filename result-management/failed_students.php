<?php
/**
 * ==========================================
 * Student Result Management & Reports
 * Failed Students Report & Remediation Tracking
 * ==========================================
 */

$pageTitle = "Failed Students Report - Student Result Management & Reports";
include(__DIR__ . '/header.php');

$deptFilter = isset($_GET['department_id']) ? (int)$_GET['department_id'] : 0;
$examFilter = isset($_GET['exam_id']) ? (int)$_GET['exam_id'] : 0;

$departments = dbFetchAll("SELECT * FROM departments ORDER BY department_name ASC");
$exams = dbFetchAll("SELECT * FROM exams ORDER BY exam_name ASC");

$where = ["r.status = 'Fail'"];
$params = [];

if ($deptFilter > 0) {
    $where[] = "s.department_id = ?";
    $params[] = $deptFilter;
}

if ($examFilter > 0) {
    $where[] = "r.exam_id = ?";
    $params[] = $examFilter;
}

$whereClause = implode(" AND ", $where);

// Fetch Failed Students List
$failedSql = "
    SELECT 
        r.id, r.marks, r.total_marks, r.percentage, r.status,
        s.name as student_name, s.enrollment_no, s.email,
        d.department_name, d.department_code,
        e.exam_name
    FROM results r
    JOIN students s ON r.student_id = s.id
    JOIN departments d ON s.department_id = d.id
    JOIN exams e ON r.exam_id = e.id
    WHERE {$whereClause}
    ORDER BY r.percentage ASC
";
$failedList = dbFetchAll($failedSql, $params);

// Stats
$failedCount = count($failedList);
$avgFailedScore = 0;
if ($failedCount > 0) {
    $totalPct = array_sum(array_column($failedList, 'percentage'));
    $avgFailedScore = round($totalPct / $failedCount, 2);
}
?>

<!-- Header Filter Bar -->
<div class="custom-card">
    <div class="card-body-custom">
        <form method="GET" action="failed_students.php" class="row g-3 align-items-center">
            <div class="col-12 col-md-4">
                <label class="form-label small fw-semibold text-muted">Filter by Department</label>
                <select name="department_id" class="form-select form-select-custom" onchange="this.form.submit()">
                    <option value="0">All Departments</option>
                    <?php foreach ($departments as $dept): ?>
                        <option value="<?php echo $dept['id']; ?>" <?php echo ($deptFilter == $dept['id']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($dept['department_name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-12 col-md-4">
                <label class="form-label small fw-semibold text-muted">Filter by Exam</label>
                <select name="exam_id" class="form-select form-select-custom" onchange="this.form.submit()">
                    <option value="0">All Exams</option>
                    <?php foreach ($exams as $ex): ?>
                        <option value="<?php echo $ex['id']; ?>" <?php echo ($examFilter == $ex['id']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($ex['exam_name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-12 col-md-4 d-flex justify-content-md-end align-items-end gap-2">
                <a href="export_pdf.php?failed=1&department_id=<?php echo $deptFilter; ?>&exam_id=<?php echo $examFilter; ?>" target="_blank" class="btn btn-outline-danger">
                    <i class="fas fa-file-pdf me-1"></i> PDF Failed Report
                </a>
                <a href="export_excel.php?failed=1&department_id=<?php echo $deptFilter; ?>&exam_id=<?php echo $examFilter; ?>" class="btn btn-success-custom">
                    <i class="fas fa-file-csv me-1"></i> Export CSV
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Remediation KPI Summary -->
<div class="row g-3 mb-4">
    <div class="col-12 col-md-6 col-xl-4">
        <div class="stat-card stat-red" style="border-left: 4px solid #ef4444;">
            <div class="stat-info">
                <div class="stat-label">Total Failed Students</div>
                <div class="stat-value text-danger"><?php echo $failedCount; ?></div>
            </div>
            <div class="stat-icon" style="background-color: #fee2e2; color: #ef4444;"><i class="fas fa-user-times"></i></div>
        </div>
    </div>
    <div class="col-12 col-md-6 col-xl-4">
        <div class="stat-card stat-amber">
            <div class="stat-info">
                <div class="stat-label">Average Fail Score</div>
                <div class="stat-value text-warning"><?php echo $avgFailedScore; ?>%</div>
            </div>
            <div class="stat-icon"><i class="fas fa-exclamation-triangle"></i></div>
        </div>
    </div>
    <div class="col-12 col-md-12 col-xl-4">
        <div class="stat-card stat-blue">
            <div class="stat-info">
                <div class="stat-label">Remediation Status</div>
                <div class="stat-value text-primary">Pending Counseling</div>
            </div>
            <div class="stat-icon"><i class="fas fa-chalkboard-teacher"></i></div>
        </div>
    </div>
</div>

<!-- Failed Students Table -->
<div class="custom-card">
    <div class="card-header-custom">
        <h3 class="card-header-title text-danger">
            <i class="fas fa-exclamation-circle text-danger me-2"></i> Failed Students Remediation List (< 40%)
        </h3>
        <span class="badge bg-danger-subtle text-danger border border-danger border-opacity-25"><?php echo $failedCount; ?> Records Found</span>
    </div>
    <div class="card-body-custom p-0">
        <div class="table-responsive">
            <table class="table custom-table mb-0">
                <thead>
                    <tr>
                        <th>Student Name</th>
                        <th>Enrollment No</th>
                        <th>Department</th>
                        <th>Exam</th>
                        <th>Marks Obtained</th>
                        <th>Total Marks</th>
                        <th>Percentage</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($failedList)): foreach ($failedList as $row): ?>
                    <tr>
                        <td class="fw-semibold text-dark"><?php echo htmlspecialchars($row['student_name']); ?></td>
                        <td><code><?php echo htmlspecialchars($row['enrollment_no']); ?></code></td>
                        <td><?php echo htmlspecialchars($row['department_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['exam_name']); ?></td>
                        <td class="fw-bold text-danger"><?php echo $row['marks']; ?></td>
                        <td><?php echo $row['total_marks']; ?></td>
                        <td class="fw-bold text-danger"><?php echo number_format($row['percentage'], 2); ?>%</td>
                        <td>
                            <span class="badge-status badge-fail"><i class="fas fa-times-circle"></i> Fail</span>
                        </td>
                        <td>
                            <a href="marksheet.php?id=<?php echo $row['id']; ?>" class="action-btn action-btn-view" title="View Marksheet">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; else: ?>
                    <tr>
                        <td colspan="9" class="text-center py-5 text-muted">
                            <i class="fas fa-check-circle fs-2 text-success d-block mb-2"></i>
                            Great news! No failed students match the selected filter criteria.
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include(__DIR__ . '/footer.php'); ?>
