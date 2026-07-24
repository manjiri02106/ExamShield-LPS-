<?php
/**
 * ==========================================
 * ExamShield LPS - Module 3: Marks Management
 * ==========================================
 */

$pageTitle = "Marks Management - ExamShield LPS";
require_once(__DIR__ . '/database.php');

session_start();

$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$deptFilter = isset($_GET['department_id']) ? (int)$_GET['department_id'] : 0;
$examFilter = isset($_GET['exam_id']) ? (int)$_GET['exam_id'] : 0;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 10;
$offset = ($page - 1) * $limit;

$departments = dbFetchAll("SELECT * FROM departments ORDER BY department_name ASC");
$exams = dbFetchAll("SELECT * FROM exams ORDER BY exam_name ASC");
$students = dbFetchAll("SELECT s.*, d.department_name FROM students s JOIN departments d ON s.department_id = d.department_id ORDER BY s.student_name ASC");

$where = ["1=1"];
$params = [];
if ($deptFilter > 0) { $where[] = "s.department_id = ?"; $params[] = $deptFilter; }
if ($examFilter > 0) { $where[] = "r.exam_id = ?"; $params[] = $examFilter; }
if (!empty($search)) {
    $where[] = "(s.student_name LIKE ? OR s.enrollment_no LIKE ? OR e.exam_name LIKE ?)";
    $searchTerm = "%{$search}%";
    $params[] = $searchTerm; $params[] = $searchTerm; $params[] = $searchTerm;
}
$whereClause = implode(" AND ", $where);

$totalRecords = dbFetchOne("
    SELECT COUNT(*) as count 
    FROM results r
    JOIN students s ON r.student_id = s.student_id
    JOIN exams e ON r.exam_id = e.exam_id
    WHERE {$whereClause}
", $params)['count'] ?? 0;
$totalPages = max(ceil($totalRecords / $limit), 1);

$marksList = dbFetchAll("
    SELECT 
        r.result_id as id, r.student_id, r.exam_id, r.marks_obtained, r.total_marks, r.percentage, r.status,
        s.student_name, s.enrollment_no, d.department_name, e.exam_name
    FROM results r
    JOIN students s ON r.student_id = s.student_id
    JOIN departments d ON s.department_id = d.department_id
    JOIN exams e ON r.exam_id = e.exam_id
    WHERE {$whereClause}
    ORDER BY r.result_id DESC
    LIMIT {$limit} OFFSET {$offset}
", $params);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/results.css">
</head>
<body>

<div class="app-wrapper">
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header"><i class="fas fa-shield-alt"></i><span>ExamShield LPS</span></div>
        <ul class="sidebar-menu">
            <li class="menu-item"><a href="analytics_dashboard.php" class="menu-link"><i class="fas fa-home"></i> Dashboard</a></li>
            <li class="menu-item"><a href="#" class="menu-link"><i class="fas fa-university"></i> Institutions</a></li>
            <li class="menu-item"><a href="department_report.php" class="menu-link"><i class="fas fa-building"></i> Departments</a></li>
            <li class="menu-item"><a href="#" class="menu-link"><i class="fas fa-users"></i> Users</a></li>
            <li class="menu-item"><a href="generate_result.php" class="menu-link"><i class="fas fa-file-alt"></i> Exams</a></li>
            <li class="menu-item"><a href="marks.php" class="menu-link active"><i class="fas fa-chart-pie"></i> Reports</a></li>
            <li class="menu-item"><a href="#" class="menu-link"><i class="fas fa-bell"></i> Notifications</a></li>
            <li class="menu-item"><a href="#" class="menu-link"><i class="fas fa-cog"></i> Settings</a></li>
        </ul>
    </aside>

    <div class="main-content">
        <header class="top-header">
            <div class="header-left"><button class="mobile-toggle" id="sidebarToggle"><i class="fas fa-bars"></i></button><h2 class="breadcrumb-title">Marks Management</h2></div>
            <div class="header-right">
                <div class="search-box"><i class="fas fa-search"></i><input type="text" placeholder="Search..."></div>
                <a href="#" class="notification-icon"><i class="fas fa-bell"></i><span class="notification-badge"></span></a>
                <div class="user-profile"><div class="avatar">A</div><div class="d-none d-sm-block"><div style="font-size: 0.85rem; font-weight: 600; line-height: 1;">Admin User</div><span class="text-muted" style="font-size: 0.7rem;">Administrator</span></div></div>
            </div>
        </header>

        <main class="content-area">
            <?php if (isset($_SESSION['flash_msg'])): ?>
                <div class="alert alert-<?php echo $_SESSION['flash_type']; ?> alert-dismissible fade show mb-4">
                    <i class="fas fa-info-circle me-2"></i> <?php echo htmlspecialchars($_SESSION['flash_msg']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php unset($_SESSION['flash_msg'], $_SESSION['flash_type']); ?>
            <?php endif; ?>

            <div class="module-card">
                <div class="module-card-header">
                    <h3 class="module-card-title">Manage Student Marks</h3>
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#marksModal" onclick="resetModal()">
                        <i class="fas fa-plus-circle me-1"></i> Add Marks
                    </button>
                </div>
                
                <div class="p-3 bg-light border-bottom">
                    <form method="GET" action="marks.php" class="row g-2 align-items-center">
                        <div class="col-12 col-md-3">
                            <select name="department_id" class="form-select form-select-sm" onchange="this.form.submit()">
                                <option value="0">All Departments</option>
                                <?php foreach ($departments as $dept): ?>
                                    <option value="<?php echo $dept['department_id']; ?>" <?php echo ($deptFilter == $dept['department_id']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($dept['department_name']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-12 col-md-3">
                            <select name="exam_id" class="form-select form-select-sm" onchange="this.form.submit()">
                                <option value="0">All Examinations</option>
                                <?php foreach ($exams as $ex): ?>
                                    <option value="<?php echo $ex['exam_id']; ?>" <?php echo ($examFilter == $ex['exam_id']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($ex['exam_name']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-12 col-md-4">
                            <input type="text" name="search" class="form-control form-control-sm" placeholder="Search Name or Enrollment No..." value="<?php echo htmlspecialchars($search); ?>">
                        </div>
                        <div class="col-12 col-md-2 d-flex gap-1">
                            <button type="submit" class="btn btn-sm btn-primary w-50">Search</button>
                            <a href="marks.php" class="btn btn-sm btn-secondary w-50">Reset</a>
                        </div>
                    </form>
                </div>

                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>Student Name</th>
                                <th>Enrollment No</th>
                                <th>Department</th>
                                <th>Exam Name</th>
                                <th>Marks</th>
                                <th>Total</th>
                                <th>Percentage</th>
                                <th>Status</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($marksList)): foreach ($marksList as $row): ?>
                            <tr>
                                <td class="fw-bold"><?php echo htmlspecialchars($row['student_name']); ?></td>
                                <td><?php echo htmlspecialchars($row['enrollment_no']); ?></td>
                                <td><span class="text-muted small"><?php echo htmlspecialchars($row['department_name']); ?></span></td>
                                <td><?php echo htmlspecialchars($row['exam_name']); ?></td>
                                <td class="fw-bold text-primary"><?php echo number_format($row['marks_obtained'], 2); ?></td>
                                <td><?php echo number_format($row['total_marks'], 2); ?></td>
                                <td class="fw-bold"><?php echo number_format($row['percentage'], 2); ?>%</td>
                                <td>
                                    <?php if ($row['status'] === 'Pass'): ?>
                                        <span class="badge-pass">PASS</span>
                                    <?php else: ?>
                                        <span class="badge-fail">FAIL</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-end">
                                    <div class="btn-group btn-group-sm">
                                        <a href="marksheet.php?id=<?php echo $row['id']; ?>" class="btn btn-outline-primary" title="View"><i class="fas fa-eye"></i></a>
                                        <button class="btn btn-outline-warning btn-edit-marks" 
                                                data-bs-toggle="modal" data-bs-target="#marksModal"
                                                data-id="<?php echo $row['id']; ?>"
                                                data-student="<?php echo $row['student_id']; ?>"
                                                data-exam="<?php echo $row['exam_id']; ?>"
                                                data-marks="<?php echo $row['marks_obtained']; ?>"
                                                data-total="<?php echo $row['total_marks']; ?>"
                                                title="Edit"><i class="fas fa-edit"></i></button>
                                        <a href="save_result.php?action=delete&id=<?php echo $row['id']; ?>&redirect=marks.php" 
                                           class="btn btn-outline-danger" onclick="return confirm('Delete this record?');" title="Delete"><i class="fas fa-trash-alt"></i></a>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; else: ?>
                            <tr><td colspan="9" class="text-center py-4 text-muted">No marks records found.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <?php if ($totalPages > 1): ?>
                <div class="p-3 border-top d-flex justify-content-between align-items-center">
                    <span class="small text-muted">Page <?php echo $page; ?> of <?php echo $totalPages; ?></span>
                    <ul class="pagination pagination-sm mb-0">
                        <li class="page-item <?php echo ($page <= 1) ? 'disabled' : ''; ?>"><a class="page-link" href="?page=<?php echo $page-1; ?>&search=<?php echo urlencode($search); ?>&department_id=<?php echo $deptFilter; ?>&exam_id=<?php echo $examFilter; ?>">Prev</a></li>
                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                            <li class="page-item <?php echo ($page == $i) ? 'active' : ''; ?>"><a class="page-link" href="?page=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>&department_id=<?php echo $deptFilter; ?>&exam_id=<?php echo $examFilter; ?>"><?php echo $i; ?></a></li>
                        <?php endfor; ?>
                        <li class="page-item <?php echo ($page >= $totalPages) ? 'disabled' : ''; ?>"><a class="page-link" href="?page=<?php echo $page+1; ?>&search=<?php echo urlencode($search); ?>&department_id=<?php echo $deptFilter; ?>&exam_id=<?php echo $examFilter; ?>">Next</a></li>
                    </ul>
                </div>
                <?php endif; ?>
            </div>
        </main>
    </div>
</div>

<!-- Add / Edit Marks Modal -->
<div class="modal fade" id="marksModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow" style="border-radius: 12px;">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fw-bold" id="marksModalLabel"><i class="fas fa-edit me-2"></i>Enter Student Marks</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="marksForm" method="POST" action="save_result.php">
                <input type="hidden" name="redirect" value="marks.php">
                <input type="hidden" name="result_id" id="modal_result_id" value="">
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Select Student</label>
                        <select name="student_id" id="modal_student_id" class="form-select" required>
                            <option value="">-- Choose Student --</option>
                            <?php foreach ($students as $st): ?>
                                <option value="<?php echo $st['student_id']; ?>"><?php echo htmlspecialchars($st['student_name']); ?> (<?php echo htmlspecialchars($st['enrollment_no']); ?>)</option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Select Examination</label>
                        <select name="exam_id" id="modal_exam_id" class="form-select" required>
                            <option value="">-- Choose Exam --</option>
                            <?php foreach ($exams as $ex): ?>
                                <option value="<?php echo $ex['exam_id']; ?>"><?php echo htmlspecialchars($ex['exam_name']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="row g-3">
                        <div class="col-6">
                            <label class="form-label fw-semibold">Marks Obtained</label>
                            <input type="number" step="0.01" min="0" name="marks" id="modal_marks" class="form-control" required placeholder="e.g. 85">
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-semibold">Total Marks</label>
                            <input type="number" step="0.01" min="1" name="total_marks" id="modal_total_marks" class="form-control" value="100" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Save Marks</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/results.js"></script>
<script>
function resetModal() {
    document.getElementById('modal_result_id').value = '';
    document.getElementById('modal_student_id').value = '';
    document.getElementById('modal_exam_id').value = '';
    document.getElementById('modal_marks').value = '';
    document.getElementById('modal_total_marks').value = '100';
}
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.btn-edit-marks').forEach(function(btn) {
        btn.addEventListener('click', function() {
            document.getElementById('modal_result_id').value = this.getAttribute('data-id');
            document.getElementById('modal_student_id').value = this.getAttribute('data-student');
            document.getElementById('modal_exam_id').value = this.getAttribute('data-exam');
            document.getElementById('modal_marks').value = this.getAttribute('data-marks');
            document.getElementById('modal_total_marks').value = this.getAttribute('data-total');
        });
    });
});
</script>
</body>
</html>
