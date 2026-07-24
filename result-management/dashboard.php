<?php
/**
 * ==========================================
 * ExamShield LPS - Result Management & Reports Dashboard
 * Modern 60% Left Table / 40% Right Analytics Layout
 * ==========================================
 */

$pageTitle = "Student Result Management & Reports - ExamShield LPS";
include(__DIR__ . '/header.php');

// Fetch Dynamic Statistics
$totalExams = dbFetchOne("SELECT COUNT(*) as count FROM exams")['count'] ?? 0;
$totalStudents = dbFetchOne("SELECT COUNT(*) as count FROM students")['count'] ?? 0;
$avgScore = dbFetchOne("SELECT ROUND(AVG(percentage), 2) as avg_score FROM results")['avg_score'] ?? 0.00;

$totalResultsCount = dbFetchOne("SELECT COUNT(*) as count FROM results")['count'] ?? 0;
$passResultsCount = dbFetchOne("SELECT COUNT(*) as count FROM results WHERE status = 'Pass'")['count'] ?? 0;
$passPercentage = ($totalResultsCount > 0) ? round(($passResultsCount / $totalResultsCount) * 100, 1) : 0.00;

// Filter & Pagination Parameters
$examFilter = isset($_GET['exam_id']) ? (int)$_GET['exam_id'] : 0;
$deptFilter = isset($_GET['department_id']) ? (int)$_GET['department_id'] : 0;
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 10;
$offset = ($page - 1) * $limit;

$departments = dbFetchAll("SELECT * FROM departments ORDER BY department_name ASC");
$exams = dbFetchAll("SELECT * FROM exams ORDER BY exam_name ASC");
$allStudents = dbFetchAll("SELECT s.*, d.department_code FROM students s JOIN departments d ON s.department_id = d.department_id ORDER BY s.student_name ASC");

// Build SQL filters
$where = ["1=1"];
$params = [];

if ($examFilter > 0) {
    $where[] = "r.exam_id = ?";
    $params[] = $examFilter;
}
if ($deptFilter > 0) {
    $where[] = "s.department_id = ?";
    $params[] = $deptFilter;
}
if (!empty($search)) {
    $where[] = "(s.student_name LIKE ? OR s.roll_no LIKE ? OR e.exam_name LIKE ?)";
    $searchTerm = "%{$search}%";
    $params[] = $searchTerm;
    $params[] = $searchTerm;
    $params[] = $searchTerm;
}
$whereClause = implode(" AND ", $where);

$totalRecords = dbFetchOne("
    SELECT COUNT(*) as count 
    FROM results r
    JOIN students s ON r.student_id = s.student_id
    JOIN exams e ON r.exam_id = e.exam_id
    WHERE {$whereClause}
", $params)['count'] ?? 0;

$totalPages = ceil($totalRecords / $limit);

$resultsList = dbFetchAll("
    SELECT 
        r.result_id as id, r.student_id, r.exam_id, r.obtained_marks as marks, r.total_marks, r.percentage, r.status,
        s.student_name, s.roll_no as enrollment_no,
        d.department_name,
        e.exam_name
    FROM results r
    JOIN students s ON r.student_id = s.student_id
    JOIN departments d ON s.department_id = d.department_id
    JOIN exams e ON r.exam_id = e.exam_id
    WHERE {$whereClause}
    ORDER BY r.result_id DESC
    LIMIT {$limit} OFFSET {$offset}
", $params);
?>

<!-- MAIN 2-COLUMN LAYOUT: LEFT 60% RESULT TABLE | RIGHT 40% ANALYTICS DASHBOARD -->
<div class="row g-3">

    <!-- LEFT SIDE (60%): RESULT MANAGEMENT TABLE -->
    <div class="col-12 col-xl-7">
        <div class="ui-card h-100 mb-0">
            <div class="ui-card-header">
                <h2 class="ui-card-title">
                    <i class="fas fa-list-alt text-primary me-2"></i> Results
                </h2>
                <div class="d-flex align-items-center gap-2">
                    <!-- Green Export Button -->
                    <div class="dropdown">
                        <button class="btn btn-export-green dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="fas fa-file-export me-1"></i> Export
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow">
                            <li><a class="dropdown-item" href="export_excel.php?exam_id=<?php echo $examFilter; ?>&department_id=<?php echo $deptFilter; ?>"><i class="fas fa-file-csv text-success me-2"></i> Export CSV</a></li>
                            <li><a class="dropdown-item" href="export_pdf.php?exam_id=<?php echo $examFilter; ?>&department_id=<?php echo $deptFilter; ?>" target="_blank"><i class="fas fa-file-pdf text-danger me-2"></i> Export PDF</a></li>
                        </ul>
                    </div>

                    <!-- Add Result Modal Button -->
                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#resultModal">
                        <i class="fas fa-plus-circle me-1"></i> Add Result
                    </button>
                </div>
            </div>

            <!-- Top Filter Bar -->
            <div class="p-3 bg-light border-bottom">
                <form method="GET" action="dashboard.php" class="row g-2">
                    <div class="col-12 col-sm-4">
                        <select name="exam_id" class="form-select form-select-sm" onchange="this.form.submit()">
                            <option value="0">All Exams</option>
                            <?php foreach ($exams as $ex): ?>
                                <option value="<?php echo $ex['exam_id']; ?>" <?php echo ($examFilter == $ex['exam_id']) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($ex['exam_name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-12 col-sm-4">
                        <select name="department_id" class="form-select form-select-sm" onchange="this.form.submit()">
                            <option value="0">All Departments</option>
                            <?php foreach ($departments as $dept): ?>
                                <option value="<?php echo $dept['department_id']; ?>" <?php echo ($deptFilter == $dept['department_id']) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($dept['department_name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-12 col-sm-4">
                        <div class="input-group input-group-sm">
                            <input type="text" name="search" class="form-control" placeholder="Search student..." value="<?php echo htmlspecialchars($search); ?>">
                            <button class="btn btn-outline-secondary" type="submit"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Results Table -->
            <div class="table-responsive">
                <table class="dashboard-table">
                    <thead>
                        <tr>
                            <th>Student</th>
                            <th>Enrollment No.</th>
                            <th>Exam</th>
                            <th>Marks</th>
                            <th>Total</th>
                            <th>Percentage</th>
                            <th>Result</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($resultsList)): foreach ($resultsList as $res): ?>
                        <tr>
                            <td class="fw-bold"><?php echo htmlspecialchars($res['student_name']); ?></td>
                            <td><code><?php echo htmlspecialchars($res['enrollment_no']); ?></code></td>
                            <td><small class="text-muted"><?php echo htmlspecialchars($res['exam_name']); ?></small></td>
                            <td class="fw-bold text-primary"><?php echo number_format($res['marks'], 2); ?></td>
                            <td><?php echo number_format($res['total_marks'], 2); ?></td>
                            <td class="fw-bold"><?php echo number_format($res['percentage'], 2); ?>%</td>
                            <td>
                                <?php if ($res['status'] === 'Pass'): ?>
                                    <span class="badge-pass-green"><i class="fas fa-check-circle me-1"></i> Pass</span>
                                <?php else: ?>
                                    <span class="badge-fail-red"><i class="fas fa-times-circle me-1"></i> Fail</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-end">
                                <div class="btn-group btn-group-sm">
                                    <a href="marksheet.php?id=<?php echo $res['id']; ?>" class="btn btn-sm btn-outline-primary" title="View Marksheet">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <button class="btn btn-sm btn-outline-warning btn-edit-result"
                                            data-bs-toggle="modal" 
                                            data-bs-target="#resultModal"
                                            data-id="<?php echo $res['id']; ?>"
                                            data-student="<?php echo $res['student_id']; ?>"
                                            data-exam="<?php echo $res['exam_id']; ?>"
                                            data-marks="<?php echo $res['marks']; ?>"
                                            data-total="<?php echo $res['total_marks']; ?>"
                                            title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <a href="save_result.php?action=delete&id=<?php echo $res['id']; ?>&redirect=dashboard.php" 
                                       class="btn btn-sm btn-outline-danger" 
                                       onclick="return confirm('Delete result entry?');" 
                                       title="Delete">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; else: ?>
                        <tr><td colspan="8" class="text-center py-4 text-muted">No student results found matching filters.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Table Pagination -->
            <?php if ($totalPages > 1): ?>
            <div class="p-3 border-top d-flex justify-content-between align-items-center">
                <span class="small text-muted">Page <?php echo $page; ?> of <?php echo $totalPages; ?></span>
                <ul class="pagination pagination-sm mb-0">
                    <li class="page-item <?php echo ($page <= 1) ? 'disabled' : ''; ?>">
                        <a class="page-link" href="?page=<?php echo $page - 1; ?>&exam_id=<?php echo $examFilter; ?>&department_id=<?php echo $deptFilter; ?>&search=<?php echo urlencode($search); ?>">Prev</a>
                    </li>
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <li class="page-item <?php echo ($page == $i) ? 'active' : ''; ?>">
                            <a class="page-link" href="?page=<?php echo $i; ?>&exam_id=<?php echo $examFilter; ?>&department_id=<?php echo $deptFilter; ?>&search=<?php echo urlencode($search); ?>"><?php echo $i; ?></a>
                        </li>
                    <?php endfor; ?>
                    <li class="page-item <?php echo ($page >= $totalPages) ? 'disabled' : ''; ?>">
                        <a class="page-link" href="?page=<?php echo $page + 1; ?>&exam_id=<?php echo $examFilter; ?>&department_id=<?php echo $deptFilter; ?>&search=<?php echo urlencode($search); ?>">Next</a>
                    </li>
                </ul>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- RIGHT SIDE (40%): ANALYTICS DASHBOARD -->
    <div class="col-12 col-xl-5">

        <!-- Top 4 Statistic Cards (2x2 Grid) -->
        <div class="row g-2 mb-3">
            <div class="col-6">
                <div class="mini-stat-card">
                    <div>
                        <div class="mini-stat-label">Total Exams</div>
                        <div class="mini-stat-val"><?php echo number_format($totalExams); ?></div>
                    </div>
                    <div class="mini-stat-icon bg-primary-subtle text-primary"><i class="fas fa-file-signature"></i></div>
                </div>
            </div>
            <div class="col-6">
                <div class="mini-stat-card">
                    <div>
                        <div class="mini-stat-label">Total Students</div>
                        <div class="mini-stat-val"><?php echo number_format($totalStudents); ?></div>
                    </div>
                    <div class="mini-stat-icon bg-info-subtle text-info"><i class="fas fa-user-graduate"></i></div>
                </div>
            </div>
            <div class="col-6">
                <div class="mini-stat-card">
                    <div>
                        <div class="mini-stat-label">Average Score</div>
                        <div class="mini-stat-val text-warning"><?php echo $avgScore; ?>%</div>
                    </div>
                    <div class="mini-stat-icon bg-warning-subtle text-warning"><i class="fas fa-chart-line"></i></div>
                </div>
            </div>
            <div class="col-6">
                <div class="mini-stat-card">
                    <div>
                        <div class="mini-stat-label">Pass Percentage</div>
                        <div class="mini-stat-val text-success"><?php echo $passPercentage; ?>%</div>
                    </div>
                    <div class="mini-stat-icon bg-success-subtle text-success"><i class="fas fa-check-circle"></i></div>
                </div>
            </div>
        </div>

        <!-- Line Chart: Performance Overview -->
        <div class="ui-card mb-3">
            <div class="ui-card-header">
                <h3 class="ui-card-title"><i class="fas fa-chart-area text-primary me-2"></i> Performance Overview</h3>
                <span class="badge bg-primary-subtle text-primary">Line Chart</span>
            </div>
            <div class="ui-card-body">
                <div style="height: 220px; position: relative;">
                    <canvas id="performanceLineChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Doughnut Chart: Result Summary -->
        <div class="ui-card mb-0">
            <div class="ui-card-header">
                <h3 class="ui-card-title"><i class="fas fa-chart-pie text-success me-2"></i> Result Summary</h3>
                <span class="badge bg-success-subtle text-success">Doughnut Chart</span>
            </div>
            <div class="ui-card-body">
                <div style="height: 200px; position: relative;">
                    <canvas id="resultSummaryDoughnutChart"></canvas>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Add / Edit Result Modal -->
<div class="modal fade" id="resultModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 16px;">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fw-bold" id="resultModalLabel"><i class="fas fa-plus-circle me-2"></i>Add Result</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="resultForm" method="POST" action="save_result.php">
                <input type="hidden" name="redirect" value="dashboard.php">
                <input type="hidden" name="result_id" id="result_id" value="">
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Student</label>
                        <select name="student_id" id="student_id" class="form-select" required>
                            <option value="">-- Choose Student --</option>
                            <?php foreach ($allStudents as $st): ?>
                                <option value="<?php echo $st['student_id']; ?>">
                                    <?php echo htmlspecialchars($st['student_name']); ?> (<?php echo htmlspecialchars($st['roll_no']); ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Exam</label>
                        <select name="exam_id" id="exam_id" class="form-select" required>
                            <option value="">-- Choose Exam --</option>
                            <?php foreach ($exams as $ex): ?>
                                <option value="<?php echo $ex['exam_id']; ?>">
                                    <?php echo htmlspecialchars($ex['exam_name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="row g-3">
                        <div class="col-6">
                            <label class="form-label fw-semibold">Marks Obtained</label>
                            <input type="number" step="0.01" min="0" name="marks" id="marks" class="form-control" required placeholder="85">
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-semibold">Total Marks</label>
                            <input type="number" step="0.01" min="1" name="total_marks" id="total_marks" class="form-control" value="100.00" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Save Result</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include(__DIR__ . '/footer.php'); ?>
