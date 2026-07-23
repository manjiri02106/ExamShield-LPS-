<?php
/**
 * ==========================================
 * Student Result Management & Reports
 * Result Management & Results List Page
 * ==========================================
 */

$pageTitle = "Result Management - Student Result Management & Reports";
include(__DIR__ . '/header.php');

session_start();

// Get Filter & Pagination Input
$examFilter = isset($_GET['exam_id']) ? (int)$_GET['exam_id'] : 0;
$deptFilter = isset($_GET['department_id']) ? (int)$_GET['department_id'] : 0;
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$sortBy = isset($_GET['sort']) ? $_GET['sort'] : 'r.id';
$order = isset($_GET['order']) && strtolower($_GET['order']) === 'asc' ? 'ASC' : 'DESC';

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 10;
$offset = ($page - 1) * $limit;

// Fetch Dropdown Data
$departments = dbFetchAll("SELECT * FROM departments ORDER BY department_name ASC");
$exams = dbFetchAll("SELECT * FROM exams ORDER BY exam_name ASC");
$students = dbFetchAll("SELECT s.*, d.department_code FROM students s JOIN departments d ON s.department_id = d.id ORDER BY s.name ASC");

// Build Query Conditions
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
    $where[] = "(s.name LIKE ? OR s.enrollment_no LIKE ? OR e.exam_name LIKE ?)";
    $searchTerm = "%{$search}%";
    $params[] = $searchTerm;
    $params[] = $searchTerm;
    $params[] = $searchTerm;
}

$whereClause = implode(" AND ", $where);

// Allowed sort fields map
$allowedSorts = [
    'name' => 's.name',
    'enrollment' => 's.enrollment_no',
    'exam' => 'e.exam_name',
    'marks' => 'r.marks',
    'percentage' => 'r.percentage',
    'status' => 'r.status',
    'id' => 'r.id'
];

$sortColumn = isset($allowedSorts[$sortBy]) ? $allowedSorts[$sortBy] : 'r.id';

// Count total records
$countSql = "
    SELECT COUNT(*) as count 
    FROM results r
    JOIN students s ON r.student_id = s.id
    JOIN exams e ON r.exam_id = e.id
    WHERE {$whereClause}
";
$totalRecords = dbFetchOne($countSql, $params)['count'] ?? 0;
$totalPages = ceil($totalRecords / $limit);

// Fetch Paginated Results
$sql = "
    SELECT 
        r.id, r.student_id, r.exam_id, r.marks, r.total_marks, r.percentage, r.status, r.created_at,
        s.name as student_name, s.enrollment_no, s.email,
        d.department_name, d.department_code,
        e.exam_name, e.exam_code
    FROM results r
    JOIN students s ON r.student_id = s.id
    JOIN departments d ON s.department_id = d.id
    JOIN exams e ON r.exam_id = e.id
    WHERE {$whereClause}
    ORDER BY {$sortColumn} {$order}
    LIMIT {$limit} OFFSET {$offset}
";
$resultsList = dbFetchAll($sql, $params);
?>

<!-- Flash Notification Banner -->
<?php if (isset($_SESSION['flash_msg'])): ?>
<div class="alert alert-<?php echo $_SESSION['flash_type']; ?> alert-dismissible fade show mb-4 shadow-sm" role="alert">
    <i class="fas <?php echo $_SESSION['flash_type'] === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'; ?> me-2"></i>
    <?php 
        echo htmlspecialchars($_SESSION['flash_msg']); 
        unset($_SESSION['flash_msg']);
        unset($_SESSION['flash_type']);
    ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php endif; ?>

<!-- Top Filter & Search Controls Bar -->
<div class="filter-bar">
    <form method="GET" action="results.php" class="row g-3 align-items-center">
        <!-- Exam Dropdown Filter -->
        <div class="col-12 col-md-3">
            <label class="form-label small fw-semibold text-muted mb-1">Filter by Exam</label>
            <select name="exam_id" class="form-select form-select-custom" onchange="this.form.submit()">
                <option value="0">All Exams</option>
                <?php foreach ($exams as $ex): ?>
                    <option value="<?php echo $ex['id']; ?>" <?php echo ($examFilter == $ex['id']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($ex['exam_name']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Department Dropdown Filter -->
        <div class="col-12 col-md-3">
            <label class="form-label small fw-semibold text-muted mb-1">Filter by Department</label>
            <select name="department_id" class="form-select form-select-custom" onchange="this.form.submit()">
                <option value="0">All Departments</option>
                <?php foreach ($departments as $dept): ?>
                    <option value="<?php echo $dept['id']; ?>" <?php echo ($deptFilter == $dept['id']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($dept['department_name']); ?> (<?php echo htmlspecialchars($dept['department_code']); ?>)
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Search Student Textbox -->
        <div class="col-12 col-md-3">
            <label class="form-label small fw-semibold text-muted mb-1">Search Student</label>
            <div class="input-group">
                <input type="text" name="search" class="form-control form-control-custom" placeholder="Name or Enrollment No..." value="<?php echo htmlspecialchars($search); ?>">
                <button type="submit" class="btn btn-outline-secondary">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>

        <!-- Actions & Export Buttons -->
        <div class="col-12 col-md-3 d-flex align-items-end justify-content-md-end gap-2">
            <!-- Add Result Trigger Modal -->
            <button type="button" class="btn btn-primary-custom" data-bs-toggle="modal" data-bs-target="#resultModal">
                <i class="fas fa-plus-circle"></i> Add Result
            </button>

            <!-- Export Buttons Dropdown -->
            <div class="dropdown">
                <button class="btn btn-success-custom dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-file-export"></i> Export
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow">
                    <li>
                        <a class="dropdown-item" href="export_excel.php?exam_id=<?php echo $examFilter; ?>&department_id=<?php echo $deptFilter; ?>&search=<?php echo urlencode($search); ?>">
                            <i class="fas fa-file-csv text-success me-2"></i> Export CSV
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="export_pdf.php?exam_id=<?php echo $examFilter; ?>&department_id=<?php echo $deptFilter; ?>&search=<?php echo urlencode($search); ?>" target="_blank">
                            <i class="fas fa-file-pdf text-danger me-2"></i> Export PDF
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </form>
</div>

<!-- Results Management Main Table Card -->
<div class="custom-card">
    <div class="card-header-custom">
        <h3 class="card-header-title">
            <i class="fas fa-table text-primary"></i> Student Examination Results
        </h3>
        <span class="text-muted small">Showing <?php echo count($resultsList); ?> of <?php echo $totalRecords; ?> records</span>
    </div>
    <div class="card-body-custom p-0">
        <div class="table-responsive">
            <table class="table custom-table mb-0 align-middle">
                <thead>
                    <tr>
                        <th>
                            <a href="?sort=name&order=<?php echo ($sortBy === 'name' && $order === 'ASC') ? 'desc' : 'asc'; ?>&exam_id=<?php echo $examFilter; ?>&department_id=<?php echo $deptFilter; ?>&search=<?php echo urlencode($search); ?>" class="text-dark text-decoration-none">
                                Student Name <i class="fas fa-sort text-muted ms-1"></i>
                            </a>
                        </th>
                        <th>
                            <a href="?sort=enrollment&order=<?php echo ($sortBy === 'enrollment' && $order === 'ASC') ? 'desc' : 'asc'; ?>&exam_id=<?php echo $examFilter; ?>&department_id=<?php echo $deptFilter; ?>&search=<?php echo urlencode($search); ?>" class="text-dark text-decoration-none">
                                Enrollment Number <i class="fas fa-sort text-muted ms-1"></i>
                            </a>
                        </th>
                        <th>Exam</th>
                        <th>
                            <a href="?sort=marks&order=<?php echo ($sortBy === 'marks' && $order === 'ASC') ? 'desc' : 'asc'; ?>&exam_id=<?php echo $examFilter; ?>&department_id=<?php echo $deptFilter; ?>&search=<?php echo urlencode($search); ?>" class="text-dark text-decoration-none">
                                Marks Obtained <i class="fas fa-sort text-muted ms-1"></i>
                            </a>
                        </th>
                        <th>Total Marks</th>
                        <th>
                            <a href="?sort=percentage&order=<?php echo ($sortBy === 'percentage' && $order === 'ASC') ? 'desc' : 'asc'; ?>&exam_id=<?php echo $examFilter; ?>&department_id=<?php echo $deptFilter; ?>&search=<?php echo urlencode($search); ?>" class="text-dark text-decoration-none">
                                Percentage <i class="fas fa-sort text-muted ms-1"></i>
                            </a>
                        </th>
                        <th>Result Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($resultsList)): foreach ($resultsList as $res): ?>
                    <tr>
                        <td>
                            <div class="fw-semibold text-dark"><?php echo htmlspecialchars($res['student_name']); ?></div>
                            <small class="text-muted"><?php echo htmlspecialchars($res['department_name']); ?></small>
                        </td>
                        <td><code><?php echo htmlspecialchars($res['enrollment_no']); ?></code></td>
                        <td>
                            <span class="fw-medium text-secondary"><?php echo htmlspecialchars($res['exam_name']); ?></span>
                        </td>
                        <td><span class="fw-bold text-dark fs-6"><?php echo $res['marks']; ?></span></td>
                        <td><span class="text-muted"><?php echo $res['total_marks']; ?></span></td>
                        <td>
                            <div class="fw-bold fs-6 text-primary"><?php echo number_format($res['percentage'], 2); ?>%</div>
                        </td>
                        <td>
                            <?php if ($res['status'] === 'Pass'): ?>
                                <span class="badge-status badge-pass"><i class="fas fa-check-circle me-1"></i> Pass</span>
                            <?php else: ?>
                                <span class="badge-status badge-fail"><i class="fas fa-times-circle me-1"></i> Fail</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-end">
                            <div class="d-inline-flex gap-1">
                                <!-- View Marksheet -->
                                <a href="marksheet.php?id=<?php echo $res['id']; ?>" class="action-btn action-btn-view" title="View Marksheet">
                                    <i class="fas fa-eye"></i>
                                </a>
                                
                                <!-- Edit Modal Trigger -->
                                <button type="button" 
                                        class="action-btn action-btn-edit btn-edit-result" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#resultModal"
                                        data-id="<?php echo $res['id']; ?>"
                                        data-student="<?php echo $res['student_id']; ?>"
                                        data-exam="<?php echo $res['exam_id']; ?>"
                                        data-marks="<?php echo $res['marks']; ?>"
                                        data-total="<?php echo $res['total_marks']; ?>"
                                        title="Edit Result">
                                    <i class="fas fa-edit"></i>
                                </button>

                                <!-- Delete Action -->
                                <a href="save_result.php?action=delete&id=<?php echo $res['id']; ?>" 
                                   class="action-btn action-btn-delete" 
                                   onclick="return confirm('Are you sure you want to delete this result entry?');" 
                                   title="Delete Result">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; else: ?>
                    <tr>
                        <td colspan="8" class="text-center py-5 text-muted">
                            <i class="fas fa-folder-open fs-2 mb-2 d-block text-secondary"></i>
                            No student results match the specified filter criteria.
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination Footer -->
    <?php if ($totalPages > 1): ?>
    <div class="card-footer bg-transparent border-top p-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div class="small text-muted">
            Page <?php echo $page; ?> of <?php echo $totalPages; ?>
        </div>
        <nav aria-label="Result Pagination">
            <ul class="pagination pagination-sm mb-0">
                <li class="page-item <?php echo ($page <= 1) ? 'disabled' : ''; ?>">
                    <a class="page-link" href="?page=<?php echo $page - 1; ?>&exam_id=<?php echo $examFilter; ?>&department_id=<?php echo $deptFilter; ?>&search=<?php echo urlencode($search); ?>&sort=<?php echo $sortBy; ?>&order=<?php echo strtolower($order); ?>">Previous</a>
                </li>
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <li class="page-item <?php echo ($page == $i) ? 'active' : ''; ?>">
                        <a class="page-link" href="?page=<?php echo $i; ?>&exam_id=<?php echo $examFilter; ?>&department_id=<?php echo $deptFilter; ?>&search=<?php echo urlencode($search); ?>&sort=<?php echo $sortBy; ?>&order=<?php echo strtolower($order); ?>"><?php echo $i; ?></a>
                    </li>
                <?php endfor; ?>
                <li class="page-item <?php echo ($page >= $totalPages) ? 'disabled' : ''; ?>">
                    <a class="page-link" href="?page=<?php echo $page + 1; ?>&exam_id=<?php echo $examFilter; ?>&department_id=<?php echo $deptFilter; ?>&search=<?php echo urlencode($search); ?>&sort=<?php echo $sortBy; ?>&order=<?php echo strtolower($order); ?>">Next</a>
                </li>
            </ul>
        </nav>
    </div>
    <?php endif; ?>
</div>

<!-- Add / Edit Result Modal -->
<div class="modal fade" id="resultModal" tabindex="-1" aria-labelledby="resultModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 16px;">
            <div class="modal-header bg-primary text-white" style="border-top-left-radius: 16px; border-top-right-radius: 16px;">
                <h5 class="modal-title fw-bold" id="resultModalLabel">
                    <i class="fas fa-plus-circle me-2"></i>Add Student Result
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="resultForm" method="POST" action="save_result.php">
                <div class="modal-body p-4">
                    <input type="hidden" name="result_id" id="result_id" value="">
                    
                    <!-- Select Student -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Select Student <span class="text-danger">*</span></label>
                        <select name="student_id" id="student_id" class="form-select form-select-custom" required>
                            <option value="">-- Choose Student --</option>
                            <?php foreach ($students as $st): ?>
                                <option value="<?php echo $st['id']; ?>">
                                    <?php echo htmlspecialchars($st['name']); ?> (<?php echo htmlspecialchars($st['enrollment_no']); ?>) - <?php echo htmlspecialchars($st['department_code']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Select Exam -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Select Examination <span class="text-danger">*</span></label>
                        <select name="exam_id" id="exam_id" class="form-select form-select-custom" required>
                            <option value="">-- Choose Examination --</option>
                            <?php foreach ($exams as $ex): ?>
                                <option value="<?php echo $ex['id']; ?>">
                                    <?php echo htmlspecialchars($ex['exam_name']); ?> (Total Marks: <?php echo $ex['total_marks']; ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Marks Obtained & Total Marks -->
                    <div class="row g-3 mb-3">
                        <div class="col-6">
                            <label class="form-label fw-semibold">Marks Obtained <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" min="0" name="marks" id="marks" class="form-control form-control-custom" placeholder="e.g. 85" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-semibold">Total Marks <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" min="1" name="total_marks" id="total_marks" class="form-control form-control-custom" value="100.00" required>
                        </div>
                    </div>

                    <!-- Calculated Percentage & Status Preview -->
                    <div class="row g-3 p-3 bg-light rounded-3 border">
                        <div class="col-6">
                            <label class="form-label small fw-semibold text-muted">Calculated Percentage</label>
                            <div class="input-group input-group-sm">
                                <input type="text" id="percentage" class="form-control bg-white fw-bold text-primary" readonly value="0.00">
                                <span class="input-group-text">%</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-semibold text-muted">Result Status (>=40 Pass)</label>
                            <input type="text" id="status" class="form-control form-control-sm bg-white fw-bold text-muted" readonly value="Pending">
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light" style="border-bottom-left-radius: 16px; border-bottom-right-radius: 16px;">
                    <button type="button" class="btn btn-secondary rounded-3" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary-custom" id="saveResultSubmit">
                        <i class="fas fa-plus-circle me-2"></i>Save Result
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include(__DIR__ . '/footer.php'); ?>
