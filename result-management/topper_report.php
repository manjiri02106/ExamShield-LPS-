<?php
/**
 * ==========================================
 * Student Result Management & Reports
 * Topper Report & Merit Ranking
 * ==========================================
 */

$pageTitle = "Topper Report - Student Result Management & Reports";
include(__DIR__ . '/header.php');

$deptFilter = isset($_GET['department_id']) ? (int)$_GET['department_id'] : 0;
$examFilter = isset($_GET['exam_id']) ? (int)$_GET['exam_id'] : 0;

$departments = dbFetchAll("SELECT * FROM departments ORDER BY department_name ASC");
$exams = dbFetchAll("SELECT * FROM exams ORDER BY exam_name ASC");

$where = ["r.status = 'Pass'"];
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

// Query Top Performers
$toppersSql = "
    SELECT 
        s.id as student_id, s.name as student_name, s.enrollment_no, s.email,
        d.department_name, d.department_code,
        e.exam_name,
        r.marks, r.total_marks, r.percentage, r.status
    FROM results r
    JOIN students s ON r.student_id = s.id
    JOIN departments d ON s.department_id = d.id
    JOIN exams e ON r.exam_id = e.id
    WHERE {$whereClause}
    ORDER BY r.percentage DESC
    LIMIT 20
";
$toppersList = dbFetchAll($toppersSql, $params);
?>

<!-- Header Filter Card -->
<div class="custom-card">
    <div class="card-body-custom">
        <form method="GET" action="topper_report.php" class="row g-3 align-items-center">
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
                <a href="export_pdf.php?toppers=1&department_id=<?php echo $deptFilter; ?>&exam_id=<?php echo $examFilter; ?>" target="_blank" class="btn btn-outline-danger">
                    <i class="fas fa-file-pdf me-1"></i> PDF Topper Report
                </a>
                <a href="export_excel.php?toppers=1&department_id=<?php echo $deptFilter; ?>&exam_id=<?php echo $examFilter; ?>" class="btn btn-success-custom">
                    <i class="fas fa-file-csv me-1"></i> Export CSV
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Podium Top 3 Performers Section -->
<?php if (count($toppersList) >= 3 && $deptFilter == 0 && $examFilter == 0): ?>
<div class="row g-4 mb-4">
    <!-- Rank 2: Silver -->
    <div class="col-12 col-md-4 order-2 order-md-1">
        <div class="custom-card text-center p-4 h-100 border-0 shadow-sm" style="background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);">
            <div class="badge badge-rank-2 px-3 py-2 fs-6 mb-3 rounded-pill">RANK #2 - SILVER</div>
            <div class="avatar-circle mx-auto mb-3" style="width: 64px; height: 64px; font-size: 1.5rem; background: #64748b;">
                <i class="fas fa-medal"></i>
            </div>
            <h5 class="fw-bold mb-1"><?php echo htmlspecialchars($toppersList[1]['student_name']); ?></h5>
            <small class="text-muted d-block mb-3"><?php echo htmlspecialchars($toppersList[1]['department_name']); ?></small>
            <div class="display-6 fw-bold text-dark mb-1"><?php echo number_format($toppersList[1]['percentage'], 2); ?>%</div>
            <span class="badge bg-secondary-subtle text-secondary border"><?php echo htmlspecialchars($toppersList[1]['exam_name']); ?></span>
        </div>
    </div>

    <!-- Rank 1: Gold -->
    <div class="col-12 col-md-4 order-1 order-md-2">
        <div class="custom-card text-center p-4 h-100 border-2 border-warning shadow" style="background: linear-gradient(180deg, #fffbeb 0%, #ffffff 100%);">
            <div class="badge badge-rank-1 px-4 py-2 fs-6 mb-3 rounded-pill"><i class="fas fa-crown me-1"></i> RANK #1 - GOLD TOPPER</div>
            <div class="avatar-circle mx-auto mb-3 shadow" style="width: 72px; height: 72px; font-size: 1.8rem; background: #f59e0b;">
                <i class="fas fa-trophy"></i>
            </div>
            <h4 class="fw-bold mb-1 text-dark"><?php echo htmlspecialchars($toppersList[0]['student_name']); ?></h4>
            <small class="text-muted d-block mb-3"><?php echo htmlspecialchars($toppersList[0]['department_name']); ?></small>
            <div class="display-5 fw-bold text-warning mb-1"><?php echo number_format($toppersList[0]['percentage'], 2); ?>%</div>
            <span class="badge bg-warning-subtle text-dark border border-warning"><?php echo htmlspecialchars($toppersList[0]['exam_name']); ?></span>
        </div>
    </div>

    <!-- Rank 3: Bronze -->
    <div class="col-12 col-md-4 order-3">
        <div class="custom-card text-center p-4 h-100 border-0 shadow-sm" style="background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);">
            <div class="badge badge-rank-3 px-3 py-2 fs-6 mb-3 rounded-pill">RANK #3 - BRONZE</div>
            <div class="avatar-circle mx-auto mb-3" style="width: 64px; height: 64px; font-size: 1.5rem; background: #b45309;">
                <i class="fas fa-award"></i>
            </div>
            <h5 class="fw-bold mb-1"><?php echo htmlspecialchars($toppersList[2]['student_name']); ?></h5>
            <small class="text-muted d-block mb-3"><?php echo htmlspecialchars($toppersList[2]['department_name']); ?></small>
            <div class="display-6 fw-bold text-dark mb-1"><?php echo number_format($toppersList[2]['percentage'], 2); ?>%</div>
            <span class="badge bg-secondary-subtle text-secondary border"><?php echo htmlspecialchars($toppersList[2]['exam_name']); ?></span>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- Merit List Table Card -->
<div class="custom-card">
    <div class="card-header-custom">
        <h3 class="card-header-title">
            <i class="fas fa-trophy text-warning"></i> Academic Merit List & Toppers
        </h3>
        <span class="badge bg-warning-subtle text-dark border">Top <?php echo count($toppersList); ?> Rankers</span>
    </div>
    <div class="card-body-custom p-0">
        <div class="table-responsive">
            <table class="table custom-table mb-0">
                <thead>
                    <tr>
                        <th>Rank</th>
                        <th>Student Name</th>
                        <th>Enrollment No</th>
                        <th>Department</th>
                        <th>Exam</th>
                        <th>Marks Obtained</th>
                        <th>Percentage</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($toppersList)): $rank = 1; foreach ($toppersList as $top): ?>
                    <tr>
                        <td class="fw-bold">
                            <?php if ($rank === 1): ?>
                                <span class="badge badge-rank-1 px-3 py-1">#1 Gold</span>
                            <?php elseif ($rank === 2): ?>
                                <span class="badge badge-rank-2 px-3 py-1">#2 Silver</span>
                            <?php elseif ($rank === 3): ?>
                                <span class="badge badge-rank-3 px-3 py-1">#3 Bronze</span>
                            <?php else: ?>
                                <span class="badge bg-light text-dark border">#<?php echo $rank; ?></span>
                            <?php endif; ?>
                        </td>
                        <td class="fw-semibold"><?php echo htmlspecialchars($top['student_name']); ?></td>
                        <td><code><?php echo htmlspecialchars($top['enrollment_no']); ?></code></td>
                        <td><?php echo htmlspecialchars($top['department_name']); ?></td>
                        <td><?php echo htmlspecialchars($top['exam_name']); ?></td>
                        <td><strong><?php echo $top['marks']; ?></strong> / <?php echo $top['total_marks']; ?></td>
                        <td class="fw-bold text-success fs-6"><?php echo number_format($top['percentage'], 2); ?>%</td>
                        <td>
                            <a href="marksheet.php?id=<?php echo $top['student_id']; ?>" class="action-btn action-btn-view" title="View Marksheet">
                                <i class="fas fa-award"></i>
                            </a>
                        </td>
                    </tr>
                    <?php $rank++; endforeach; else: ?>
                    <tr>
                        <td colspan="8" class="text-center py-4 text-muted">No topper records match the specified filters.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include(__DIR__ . '/footer.php'); ?>
