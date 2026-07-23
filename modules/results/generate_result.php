<?php
/**
 * ==========================================
 * ExamShield LPS - Module 2: Result Generation
 * ==========================================
 */

$pageTitle = "Result Generation - ExamShield LPS";
require_once(__DIR__ . '/database.php');

$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$deptFilter = isset($_GET['department_id']) ? (int)$_GET['department_id'] : 0;
$examFilter = isset($_GET['exam_id']) ? (int)$_GET['exam_id'] : 0;
$statusFilter = isset($_GET['status']) ? trim($_GET['status']) : '';

$departments = dbFetchAll("SELECT * FROM departments ORDER BY department_name ASC");
$exams = dbFetchAll("SELECT * FROM exams ORDER BY exam_name ASC");

$where = ["1=1"];
$params = [];

if ($deptFilter > 0) { $where[] = "s.department_id = ?"; $params[] = $deptFilter; }
if ($examFilter > 0) { $where[] = "r.exam_id = ?"; $params[] = $examFilter; }
if (!empty($statusFilter)) { $where[] = "r.status = ?"; $params[] = $statusFilter; }
if (!empty($search)) { 
    $where[] = "(s.student_name LIKE ? OR s.enrollment_no LIKE ? OR e.exam_name LIKE ?)"; 
    $searchTerm = "%{$search}%"; $params[] = $searchTerm; $params[] = $searchTerm; $params[] = $searchTerm; 
}
$whereClause = implode(" AND ", $where);

$list = dbFetchAll("
    SELECT 
        r.result_id as id, r.marks_obtained, r.total_marks, r.percentage, r.status,
        s.student_name, s.enrollment_no, d.department_name, e.exam_name,
        DENSE_RANK() OVER (PARTITION BY r.exam_id ORDER BY r.percentage DESC) as exam_rank
    FROM results r
    JOIN students s ON r.student_id = s.student_id
    JOIN departments d ON s.department_id = d.department_id
    JOIN exams e ON r.exam_id = e.exam_id
    WHERE {$whereClause}
    ORDER BY r.exam_id, exam_rank ASC
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
            <li class="menu-item"><a href="generate_result.php" class="menu-link active"><i class="fas fa-file-alt"></i> Exams</a></li>
            <li class="menu-item"><a href="marks.php" class="menu-link"><i class="fas fa-chart-pie"></i> Reports</a></li>
            <li class="menu-item"><a href="#" class="menu-link"><i class="fas fa-bell"></i> Notifications</a></li>
            <li class="menu-item"><a href="#" class="menu-link"><i class="fas fa-cog"></i> Settings</a></li>
        </ul>
    </aside>

    <div class="main-content">
        <header class="top-header">
            <div class="header-left"><button class="mobile-toggle" id="sidebarToggle"><i class="fas fa-bars"></i></button><h2 class="breadcrumb-title">Final Result Generation</h2></div>
            <div class="header-right">
                <div class="search-box"><i class="fas fa-search"></i><input type="text" placeholder="Search..."></div>
                <a href="#" class="notification-icon"><i class="fas fa-bell"></i><span class="notification-badge"></span></a>
                <div class="user-profile"><div class="avatar">A</div><div class="d-none d-sm-block"><div style="font-size: 0.85rem; font-weight: 600; line-height: 1;">Admin User</div><span class="text-muted" style="font-size: 0.7rem;">Administrator</span></div></div>
            </div>
        </header>

        <main class="content-area">
            <div class="module-card">
                <div class="module-card-header">
                    <h3 class="module-card-title"><i class="fas fa-award text-warning me-2"></i> Rank Matrix & Result Generation</h3>
                    <div class="d-flex gap-2">
                        <a href="export_csv.php?department_id=<?php echo $deptFilter; ?>&exam_id=<?php echo $examFilter; ?>" class="btn btn-sm btn-success text-decoration-none"><i class="fas fa-file-csv me-1"></i> CSV</a>
                        <a href="export_excel.php?department_id=<?php echo $deptFilter; ?>&exam_id=<?php echo $examFilter; ?>" class="btn-export text-decoration-none"><i class="fas fa-file-excel me-1"></i> Excel</a>
                        <a href="export_pdf.php?department_id=<?php echo $deptFilter; ?>&exam_id=<?php echo $examFilter; ?>" target="_blank" class="btn btn-danger btn-sm text-decoration-none"><i class="fas fa-file-pdf me-1"></i> PDF</a>
                    </div>
                </div>

                <div class="p-3 bg-light border-bottom">
                    <form method="GET" action="generate_result.php" class="row g-2 align-items-center">
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
                                <option value="0">All Exams</option>
                                <?php foreach ($exams as $ex): ?>
                                    <option value="<?php echo $ex['exam_id']; ?>" <?php echo ($examFilter == $ex['exam_id']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($ex['exam_name']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-12 col-md-2">
                            <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                                <option value="">All Statuses</option>
                                <option value="Pass" <?php echo ($statusFilter === 'Pass') ? 'selected' : ''; ?>>Pass</option>
                                <option value="Fail" <?php echo ($statusFilter === 'Fail') ? 'selected' : ''; ?>>Fail</option>
                            </select>
                        </div>
                        <div class="col-12 col-md-3">
                            <div class="input-group input-group-sm">
                                <input type="text" name="search" class="form-control" placeholder="Search..." value="<?php echo htmlspecialchars($search); ?>">
                                <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
                            </div>
                        </div>
                        <div class="col-12 col-md-1 text-end">
                            <a href="generate_result.php" class="btn btn-secondary btn-sm w-100"><i class="fas fa-redo"></i></a>
                        </div>
                    </form>
                </div>

                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>Rank</th>
                                <th>Student Name</th>
                                <th>Enrollment No</th>
                                <th>Department</th>
                                <th>Exam Name</th>
                                <th>Percentage</th>
                                <th>Status</th>
                                <th class="text-end">Final Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($list)): foreach ($list as $row): ?>
                            <tr class="<?php echo ($row['exam_rank'] <= 3 && $row['status'] === 'Pass') ? 'bg-warning bg-opacity-10' : ''; ?>">
                                <td>
                                    <?php if ($row['exam_rank'] == 1 && $row['status'] === 'Pass'): ?>
                                        <span class="badge bg-warning text-dark"><i class="fas fa-crown"></i> 1st</span>
                                    <?php elseif ($row['exam_rank'] == 2 && $row['status'] === 'Pass'): ?>
                                        <span class="badge bg-secondary"><i class="fas fa-medal"></i> 2nd</span>
                                    <?php elseif ($row['exam_rank'] == 3 && $row['status'] === 'Pass'): ?>
                                        <span class="badge bg-danger"><i class="fas fa-award"></i> 3rd</span>
                                    <?php else: ?>
                                        <span class="fw-bold text-muted">#<?php echo $row['exam_rank']; ?></span>
                                    <?php endif; ?>
                                </td>
                                <td class="fw-bold"><?php echo htmlspecialchars($row['student_name']); ?></td>
                                <td><?php echo htmlspecialchars($row['enrollment_no']); ?></td>
                                <td><span class="text-muted small"><?php echo htmlspecialchars($row['department_name']); ?></span></td>
                                <td><?php echo htmlspecialchars($row['exam_name']); ?></td>
                                <td class="fw-bold text-primary"><?php echo number_format($row['percentage'], 2); ?>%</td>
                                <td>
                                    <?php if ($row['status'] === 'Pass'): ?>
                                        <span class="badge-pass">PASS</span>
                                    <?php else: ?>
                                        <span class="badge-fail">FAIL</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-end">
                                    <div class="btn-group btn-group-sm">
                                        <a href="marksheet.php?id=<?php echo $row['id']; ?>" class="btn btn-primary"><i class="fas fa-eye"></i> View</a>
                                        <a href="marksheet.php?id=<?php echo $row['id']; ?>&print=1" target="_blank" class="btn btn-secondary"><i class="fas fa-print"></i></a>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; else: ?>
                            <tr><td colspan="8" class="text-center py-5 text-muted">No finalized results matching filters.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/results.js"></script>
</body>
</html>
