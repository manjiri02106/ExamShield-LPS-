<?php
/**
 * ==========================================
 * ExamShield LPS - Module 4: Attendance Report
 * ==========================================
 */

$pageTitle = "Attendance Report - ExamShield LPS";
require_once(__DIR__ . '/database.php');

$deptFilter = isset($_GET['department_id']) ? (int)$_GET['department_id'] : 0;
$examFilter = isset($_GET['exam_id']) ? (int)$_GET['exam_id'] : 0;
$statusFilter = isset($_GET['attendance_status']) ? trim($_GET['attendance_status']) : '';

$departments = dbFetchAll("SELECT * FROM departments ORDER BY department_name ASC");
$exams = dbFetchAll("SELECT * FROM exams ORDER BY exam_name ASC");

// Build query
$where = ["1=1"];
$params = [];

if ($deptFilter > 0) { $where[] = "s.department_id = ?"; $params[] = $deptFilter; }
if ($examFilter > 0) { $where[] = "a.exam_id = ?"; $params[] = $examFilter; }
if (!empty($statusFilter)) { $where[] = "a.attendance_status = ?"; $params[] = $statusFilter; }

$whereClause = implode(" AND ", $where);

$attendanceList = dbFetchAll("
    SELECT 
        a.attendance_id, a.attendance_status, a.login_time, a.logout_time, a.duration,
        s.student_name, s.enrollment_no,
        d.department_name, e.exam_name
    FROM attendance a
    JOIN students s ON a.student_id = s.student_id
    JOIN departments d ON s.department_id = d.department_id
    JOIN exams e ON a.exam_id = e.exam_id
    WHERE {$whereClause}
    ORDER BY a.attendance_id DESC
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
            <div class="header-left"><button class="mobile-toggle" id="sidebarToggle"><i class="fas fa-bars"></i></button><h2 class="breadcrumb-title">Examination Attendance Report</h2></div>
            <div class="header-right">
                <div class="search-box"><i class="fas fa-search"></i><input type="text" placeholder="Search..."></div>
                <a href="#" class="notification-icon"><i class="fas fa-bell"></i><span class="notification-badge"></span></a>
                <div class="user-profile"><div class="avatar">A</div><div class="d-none d-sm-block"><div style="font-size: 0.85rem; font-weight: 600; line-height: 1;">Admin User</div><span class="text-muted" style="font-size: 0.7rem;">Administrator</span></div></div>
            </div>
        </header>

        <main class="content-area">
            <div class="module-card">
                <div class="module-card-header">
                    <h3 class="module-card-title"><i class="fas fa-user-check text-success me-2"></i> Attendance Log Records</h3>
                    <div class="d-flex gap-2">
                        <a href="export_csv.php?attendance=1&department_id=<?php echo $deptFilter; ?>&exam_id=<?php echo $examFilter; ?>" class="btn btn-sm btn-success text-decoration-none"><i class="fas fa-file-csv me-1"></i> CSV</a>
                        <a href="export_excel.php?attendance=1&department_id=<?php echo $deptFilter; ?>&exam_id=<?php echo $examFilter; ?>" class="btn-export text-decoration-none"><i class="fas fa-file-excel me-1"></i> Excel</a>
                        <a href="export_pdf.php?attendance=1&department_id=<?php echo $deptFilter; ?>&exam_id=<?php echo $examFilter; ?>" target="_blank" class="btn btn-danger btn-sm text-decoration-none"><i class="fas fa-file-pdf me-1"></i> PDF</a>
                    </div>
                </div>

                <div class="p-3 bg-light border-bottom">
                    <form method="GET" action="attendance_report.php" class="row g-2 align-items-center">
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
                        <div class="col-12 col-md-3">
                            <select name="attendance_status" class="form-select form-select-sm" onchange="this.form.submit()">
                                <option value="">All Statuses</option>
                                <option value="Present" <?php echo ($statusFilter === 'Present') ? 'selected' : ''; ?>>Present</option>
                                <option value="Absent" <?php echo ($statusFilter === 'Absent') ? 'selected' : ''; ?>>Absent</option>
                            </select>
                        </div>
                        <div class="col-12 col-md-3">
                            <a href="attendance_report.php" class="btn btn-secondary btn-sm w-100">Reset Filters</a>
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
                                <th>Status</th>
                                <th>Login Time</th>
                                <th>Logout Time</th>
                                <th>Duration (mins)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($attendanceList)): foreach ($attendanceList as $row): ?>
                            <tr>
                                <td class="fw-bold"><?php echo htmlspecialchars($row['student_name']); ?></td>
                                <td><?php echo htmlspecialchars($row['enrollment_no']); ?></td>
                                <td><span class="text-muted small"><?php echo htmlspecialchars($row['department_name']); ?></span></td>
                                <td><?php echo htmlspecialchars($row['exam_name']); ?></td>
                                <td>
                                    <?php if ($row['attendance_status'] === 'Present'): ?>
                                        <span class="badge-pass"><i class="fas fa-check me-1"></i> Present</span>
                                    <?php else: ?>
                                        <span class="badge-fail"><i class="fas fa-times me-1"></i> Absent</span>
                                    <?php endif; ?>
                                </td>
                                <td><small class="text-muted"><?php echo $row['login_time'] ? $row['login_time'] : '-'; ?></small></td>
                                <td><small class="text-muted"><?php echo $row['logout_time'] ? $row['logout_time'] : '-'; ?></small></td>
                                <td class="fw-semibold"><?php echo $row['duration']; ?> mins</td>
                            </tr>
                            <?php endforeach; else: ?>
                            <tr><td colspan="8" class="text-center py-5 text-muted">No attendance logs match the selected criteria.</td></tr>
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
