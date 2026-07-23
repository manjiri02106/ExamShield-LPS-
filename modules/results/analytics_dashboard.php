<?php
/**
 * ==========================================
 * ExamShield LPS - Module 6: Analytics Dashboard
 * ==========================================
 */

$pageTitle = "Analytics Dashboard - ExamShield LPS";
require_once(__DIR__ . '/database.php');

// Fetch Metrics
$totalExams = dbFetchOne("SELECT COUNT(*) as count FROM exams")['count'] ?? 0;
$totalStudents = dbFetchOne("SELECT COUNT(*) as count FROM students")['count'] ?? 0;
$avgScore = dbFetchOne("SELECT ROUND(AVG(percentage), 2) as avg_score FROM results")['avg_score'] ?? 0.00;
$totalResults = dbFetchOne("SELECT COUNT(*) as count FROM results")['count'] ?? 0;
$passResults = dbFetchOne("SELECT COUNT(*) as count FROM results WHERE status = 'Pass'")['count'] ?? 0;
$passPercentage = ($totalResults > 0) ? round(($passResults / $totalResults) * 100, 1) : 0.00;

// Filter & Pagination for Table
$deptFilter = isset($_GET['department_id']) ? (int)$_GET['department_id'] : 0;
$examFilter = isset($_GET['exam_id']) ? (int)$_GET['exam_id'] : 0;
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 10;
$offset = ($page - 1) * $limit;

$departments = dbFetchAll("SELECT * FROM departments ORDER BY department_name ASC");
$exams = dbFetchAll("SELECT * FROM exams ORDER BY exam_name ASC");

$where = ["1=1"];
$params = [];
if ($deptFilter > 0) { $where[] = "s.department_id = ?"; $params[] = $deptFilter; }
if ($examFilter > 0) { $where[] = "r.exam_id = ?"; $params[] = $examFilter; }
if (!empty($search)) { 
    $where[] = "(s.student_name LIKE ? OR s.enrollment_no LIKE ?)"; 
    $searchTerm = "%{$search}%"; $params[] = $searchTerm; $params[] = $searchTerm; 
}
$whereClause = implode(" AND ", $where);

$totalFiltered = dbFetchOne("
    SELECT COUNT(*) as count 
    FROM results r
    JOIN students s ON r.student_id = s.student_id
    WHERE {$whereClause}
", $params)['count'] ?? 0;
$totalPages = max(ceil($totalFiltered / $limit), 1);

$resultsList = dbFetchAll("
    SELECT 
        r.result_id as id, r.marks_obtained, r.total_marks, r.percentage, r.status,
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
    <!-- Fixed Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <i class="fas fa-shield-alt"></i>
            <span>ExamShield LPS</span>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-item"><a href="analytics_dashboard.php" class="menu-link active"><i class="fas fa-home"></i> Dashboard</a></li>
            <li class="menu-item"><a href="#" class="menu-link"><i class="fas fa-university"></i> Institutions</a></li>
            <li class="menu-item"><a href="department_report.php" class="menu-link"><i class="fas fa-building"></i> Departments</a></li>
            <li class="menu-item"><a href="#" class="menu-link"><i class="fas fa-users"></i> Users</a></li>
            <li class="menu-item"><a href="generate_result.php" class="menu-link"><i class="fas fa-file-alt"></i> Exams</a></li>
            <li class="menu-item"><a href="marks.php" class="menu-link"><i class="fas fa-chart-pie"></i> Reports</a></li>
            <li class="menu-item"><a href="#" class="menu-link"><i class="fas fa-bell"></i> Notifications</a></li>
            <li class="menu-item"><a href="#" class="menu-link"><i class="fas fa-cog"></i> Settings</a></li>
        </ul>
    </aside>

    <div class="main-content">
        <!-- Header -->
        <header class="top-header">
            <div class="header-left">
                <button class="mobile-toggle" id="sidebarToggle"><i class="fas fa-bars"></i></button>
                <h2 class="breadcrumb-title">Result Management & Reports</h2>
            </div>
            <div class="header-right">
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="Search...">
                </div>
                <a href="#" class="notification-icon">
                    <i class="fas fa-bell"></i>
                    <span class="notification-badge"></span>
                </a>
                <div class="user-profile">
                    <div class="avatar">A</div>
                    <div class="d-none d-sm-block">
                        <div style="font-size: 0.85rem; font-weight: 600; line-height: 1;">Admin User</div>
                        <span class="text-muted" style="font-size: 0.7rem;">Administrator</span>
                    </div>
                </div>
            </div>
        </header>

        <!-- Scrollable Content Area -->
        <main class="content-area">
            <div class="row g-4">
                
                <!-- LEFT PANEL (60%): RESULT TABLE -->
                <div class="col-12 col-xl-7">
                    <div class="module-card h-100 mb-0">
                        <div class="module-card-header">
                            <h3 class="module-card-title">Results</h3>
                            <div class="d-flex gap-2">
                                <div class="dropdown">
                                    <button class="btn-export dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                        <i class="fas fa-file-export me-1"></i> Export
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end shadow">
                                        <li><a class="dropdown-item" href="export_csv.php?department_id=<?php echo $deptFilter; ?>&exam_id=<?php echo $examFilter; ?>"><i class="fas fa-file-csv text-success me-2"></i> CSV</a></li>
                                        <li><a class="dropdown-item" href="export_excel.php?department_id=<?php echo $deptFilter; ?>&exam_id=<?php echo $examFilter; ?>"><i class="fas fa-file-excel text-primary me-2"></i> Excel</a></li>
                                        <li><a class="dropdown-item" href="export_pdf.php?department_id=<?php echo $deptFilter; ?>&exam_id=<?php echo $examFilter; ?>" target="_blank"><i class="fas fa-file-pdf text-danger me-2"></i> PDF</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Top Controls -->
                        <div class="p-3 border-bottom bg-light">
                            <form method="GET" action="analytics_dashboard.php" class="row g-2 align-items-center">
                                <div class="col-12 col-sm-3">
                                    <select name="exam_id" class="form-select form-select-sm" onchange="this.form.submit()">
                                        <option value="0">All Exams</option>
                                        <?php foreach ($exams as $ex): ?>
                                            <option value="<?php echo $ex['exam_id']; ?>" <?php echo ($examFilter == $ex['exam_id']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($ex['exam_name']); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-12 col-sm-3">
                                    <select name="department_id" class="form-select form-select-sm" onchange="this.form.submit()">
                                        <option value="0">All Departments</option>
                                        <?php foreach ($departments as $dept): ?>
                                            <option value="<?php echo $dept['department_id']; ?>" <?php echo ($deptFilter == $dept['department_id']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($dept['department_name']); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-12 col-sm-4">
                                    <input type="text" name="search" class="form-control form-control-sm" placeholder="Search student..." value="<?php echo htmlspecialchars($search); ?>">
                                </div>
                                <div class="col-12 col-sm-2">
                                    <button class="btn btn-sm btn-primary w-100" type="submit">Search</button>
                                </div>
                            </form>
                        </div>

                        <!-- Table -->
                        <div class="table-responsive">
                            <table class="table mb-0">
                                <thead>
                                    <tr>
                                        <th>Student</th>
                                        <th>Enrollment No.</th>
                                        <th>Exam</th>
                                        <th>Marks</th>
                                        <th>Total</th>
                                        <th>Percentage</th>
                                        <th>Result</th>
                                        <th class="text-end">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($resultsList)): foreach ($resultsList as $row): ?>
                                    <tr>
                                        <td class="fw-bold"><?php echo htmlspecialchars($row['student_name']); ?></td>
                                        <td><?php echo htmlspecialchars($row['enrollment_no']); ?></td>
                                        <td><span class="text-muted small"><?php echo htmlspecialchars($row['exam_name']); ?></span></td>
                                        <td class="fw-bold" style="color: #2563eb;"><?php echo number_format($row['marks_obtained'], 2); ?></td>
                                        <td><?php echo number_format($row['total_marks'], 2); ?></td>
                                        <td class="fw-bold"><?php echo number_format($row['percentage'], 2); ?>%</td>
                                        <td>
                                            <?php if ($row['status'] === 'Pass'): ?>
                                                <span class="badge-pass">Pass</span>
                                            <?php else: ?>
                                                <span class="badge-fail">Fail</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-end">
                                            <a href="marksheet.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-primary"><i class="fas fa-eye"></i></a>
                                        </td>
                                    </tr>
                                    <?php endforeach; else: ?>
                                    <tr><td colspan="8" class="text-center py-4 text-muted">No records found.</td></tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Pagination -->
                        <?php if ($totalPages > 1): ?>
                        <div class="p-3 border-top d-flex justify-content-between align-items-center">
                            <span class="text-muted" style="font-size: 0.85rem;">Page <?php echo $page; ?> of <?php echo $totalPages; ?></span>
                            <ul class="pagination pagination-sm mb-0">
                                <li class="page-item <?php echo ($page <= 1) ? 'disabled' : ''; ?>"><a class="page-link" href="?page=<?php echo $page-1; ?>&exam_id=<?php echo $examFilter; ?>&department_id=<?php echo $deptFilter; ?>&search=<?php echo urlencode($search); ?>">Prev</a></li>
                                <li class="page-item active"><a class="page-link" href="#"><?php echo $page; ?></a></li>
                                <li class="page-item <?php echo ($page >= $totalPages) ? 'disabled' : ''; ?>"><a class="page-link" href="?page=<?php echo $page+1; ?>&exam_id=<?php echo $examFilter; ?>&department_id=<?php echo $deptFilter; ?>&search=<?php echo urlencode($search); ?>">Next</a></li>
                            </ul>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- RIGHT PANEL (40%): ANALYTICS DASHBOARD -->
                <div class="col-12 col-xl-5">
                    <!-- 4 Top Cards -->
                    <div class="row g-3 mb-4">
                        <div class="col-6">
                            <div class="stat-card">
                                <div class="stat-icon" style="background-color: #eff6ff; color: #2563eb;"><i class="fas fa-file-alt"></i></div>
                                <div class="stat-details">
                                    <div class="stat-label">Total Exams</div>
                                    <div class="stat-value"><?php echo number_format($totalExams); ?></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="stat-card">
                                <div class="stat-icon" style="background-color: #f0fdf4; color: #16a34a;"><i class="fas fa-users"></i></div>
                                <div class="stat-details">
                                    <div class="stat-label">Total Students</div>
                                    <div class="stat-value"><?php echo number_format($totalStudents); ?></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="stat-card">
                                <div class="stat-icon" style="background-color: #fef3c7; color: #d97706;"><i class="fas fa-chart-line"></i></div>
                                <div class="stat-details">
                                    <div class="stat-label">Average Score</div>
                                    <div class="stat-value"><?php echo $avgScore; ?>%</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="stat-card">
                                <div class="stat-icon" style="background-color: #fef2f2; color: #dc2626;"><i class="fas fa-check-circle"></i></div>
                                <div class="stat-details">
                                    <div class="stat-label">Pass Percentage</div>
                                    <div class="stat-value"><?php echo $passPercentage; ?>%</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Performance Overview Line Chart -->
                    <div class="module-card mb-4">
                        <div class="module-card-header">
                            <h3 class="module-card-title">Performance Overview</h3>
                        </div>
                        <div class="module-card-body" style="height: 250px; position: relative;">
                            <canvas id="chartPerformance"></canvas>
                        </div>
                    </div>

                    <!-- Result Summary Doughnut Chart -->
                    <div class="module-card mb-4">
                        <div class="module-card-header">
                            <h3 class="module-card-title">Result Summary</h3>
                        </div>
                        <div class="module-card-body" style="height: 250px; position: relative; display: flex; justify-content: center;">
                            <canvas id="chartResultSummary"></canvas>
                        </div>
                    </div>
                    
                    <!-- Department Performance Bar Chart -->
                    <div class="module-card mb-4">
                        <div class="module-card-header">
                            <h3 class="module-card-title">Department Performance</h3>
                        </div>
                        <div class="module-card-body" style="height: 250px; position: relative;">
                            <canvas id="chartDeptPerformance"></canvas>
                        </div>
                    </div>
                    
                    <!-- Top Students Horizontal Bar Chart -->
                    <div class="module-card mb-0">
                        <div class="module-card-header">
                            <h3 class="module-card-title">Top Students</h3>
                        </div>
                        <div class="module-card-body" style="height: 250px; position: relative;">
                            <canvas id="chartTopStudents"></canvas>
                        </div>
                    </div>

                </div>
            </div>
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="assets/js/results.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    fetch('chart_data.php')
        .then(res => res.json())
        .then(data => {
            new Chart(document.getElementById('chartPerformance').getContext('2d'), {
                type: 'line',
                data: { labels: data.monthly_performance.labels, datasets: [{ label: 'Avg Score', data: data.monthly_performance.data, borderColor: '#2563EB', backgroundColor: 'rgba(37, 99, 235, 0.1)', fill: true, tension: 0.4 }] },
                options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } } }
            });
            new Chart(document.getElementById('chartResultSummary').getContext('2d'), {
                type: 'doughnut',
                data: { labels: data.pass_vs_fail.labels, datasets: [{ data: data.pass_vs_fail.data, backgroundColor: ['#16A34A', '#DC2626'], borderWidth: 0, cutout: '70%' }] },
                options: { responsive: true, maintainAspectRatio: false }
            });
            new Chart(document.getElementById('chartDeptPerformance').getContext('2d'), {
                type: 'bar',
                data: { labels: data.department_performance.labels, datasets: [{ label: 'Pass %', data: data.department_performance.data, backgroundColor: '#2563EB', borderRadius: 4 }] },
                options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } } }
            });
            new Chart(document.getElementById('chartTopStudents').getContext('2d'), {
                type: 'bar',
                data: { labels: data.top_students.labels, datasets: [{ label: 'Percentage', data: data.top_students.data, backgroundColor: '#F59E0B', borderRadius: 4 }] },
                options: { indexAxis: 'y', responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } } }
            });
        })
        .catch(err => console.error("Error loading chart data:", err));
});
</script>
</body>
</html>
