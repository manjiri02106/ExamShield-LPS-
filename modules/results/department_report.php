<?php
/**
 * ==========================================
 * ExamShield LPS - Module 5: Department Reports
 * ==========================================
 */

$pageTitle = "Department Reports - ExamShield LPS";
require_once(__DIR__ . '/database.php');

$deptStats = dbFetchAll("
    SELECT 
        d.department_id, d.department_name,
        COUNT(DISTINCT s.student_id) as total_students,
        COUNT(r.result_id) as students_appeared,
        SUM(CASE WHEN r.status = 'Pass' THEN 1 ELSE 0 END) as students_passed,
        SUM(CASE WHEN r.status = 'Fail' THEN 1 ELSE 0 END) as students_failed,
        ROUND(AVG(r.percentage), 2) as avg_percentage,
        MAX(r.percentage) as highest_score,
        MIN(r.percentage) as lowest_score
    FROM departments d
    LEFT JOIN students s ON s.department_id = d.department_id
    LEFT JOIN results r ON r.student_id = s.student_id
    GROUP BY d.department_id, d.department_name
    ORDER BY d.department_name ASC
");
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
            <li class="menu-item"><a href="department_report.php" class="menu-link active"><i class="fas fa-building"></i> Departments</a></li>
            <li class="menu-item"><a href="#" class="menu-link"><i class="fas fa-users"></i> Users</a></li>
            <li class="menu-item"><a href="generate_result.php" class="menu-link"><i class="fas fa-file-alt"></i> Exams</a></li>
            <li class="menu-item"><a href="marks.php" class="menu-link"><i class="fas fa-chart-pie"></i> Reports</a></li>
            <li class="menu-item"><a href="#" class="menu-link"><i class="fas fa-bell"></i> Notifications</a></li>
            <li class="menu-item"><a href="#" class="menu-link"><i class="fas fa-cog"></i> Settings</a></li>
        </ul>
    </aside>

    <div class="main-content">
        <header class="top-header">
            <div class="header-left"><button class="mobile-toggle" id="sidebarToggle"><i class="fas fa-bars"></i></button><h2 class="breadcrumb-title">Department Wise Reports</h2></div>
            <div class="header-right">
                <div class="search-box"><i class="fas fa-search"></i><input type="text" placeholder="Search..."></div>
                <a href="#" class="notification-icon"><i class="fas fa-bell"></i><span class="notification-badge"></span></a>
                <div class="user-profile"><div class="avatar">A</div><div class="d-none d-sm-block"><div style="font-size: 0.85rem; font-weight: 600; line-height: 1;">Admin User</div><span class="text-muted" style="font-size: 0.7rem;">Administrator</span></div></div>
            </div>
        </header>

        <main class="content-area">
            <div class="d-flex justify-content-end mb-3 gap-2">
                <a href="export_csv.php?department_report=1" class="btn btn-sm btn-success text-decoration-none"><i class="fas fa-file-csv me-1"></i> CSV</a>
                <a href="export_excel.php?department_report=1" class="btn-export text-decoration-none"><i class="fas fa-file-excel me-1"></i> Excel</a>
                <a href="export_pdf.php?department_report=1" target="_blank" class="btn btn-sm btn-danger text-decoration-none"><i class="fas fa-file-pdf me-1"></i> PDF</a>
            </div>

            <!-- Department Cards -->
            <div class="row g-4 mb-4">
                <?php foreach ($deptStats as $dept): 
                    $appeared = $dept['students_appeared'];
                    $passed = $dept['students_passed'];
                    $passRate = ($appeared > 0) ? round(($passed / $appeared) * 100, 1) : 0.00;
                ?>
                <div class="col-12 col-md-6 col-xl-4">
                    <div class="module-card h-100 mb-0">
                        <div class="module-card-body">
                            <h4 class="fw-bold text-dark mb-3"><?php echo htmlspecialchars($dept['department_name']); ?></h4>
                            <div class="row g-2 mb-3 text-center">
                                <div class="col-6">
                                    <div class="p-2 bg-light rounded border">
                                        <span class="small text-muted d-block">Average Score</span>
                                        <strong class="fs-4 text-primary"><?php echo $dept['avg_percentage'] ? $dept['avg_percentage'] : '0.00'; ?>%</strong>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="p-2 bg-light rounded border">
                                        <span class="small text-muted d-block">Pass Rate</span>
                                        <strong class="fs-4 text-success"><?php echo $passRate; ?>%</strong>
                                    </div>
                                </div>
                            </div>
                            <div class="progress mb-3" style="height: 6px;">
                                <div class="progress-bar bg-success" style="width: <?php echo $passRate; ?>%"></div>
                            </div>
                            <div class="row g-2 text-center small border-top pt-3">
                                <div class="col-3"><span class="text-muted d-block">Enrolled</span><strong><?php echo $dept['total_students']; ?></strong></div>
                                <div class="col-3"><span class="text-muted d-block">Appeared</span><strong><?php echo $dept['students_appeared']; ?></strong></div>
                                <div class="col-3"><span class="text-muted d-block">Passed</span><strong class="text-success"><?php echo $dept['students_passed']; ?></strong></div>
                                <div class="col-3"><span class="text-muted d-block">Failed</span><strong class="text-danger"><?php echo $dept['students_failed']; ?></strong></div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <!-- Summary Table -->
            <div class="module-card">
                <div class="module-card-header">
                    <h3 class="module-card-title"><i class="fas fa-chart-bar text-secondary me-2"></i> Department Metrics Summary</h3>
                </div>
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>Department Name</th>
                                <th>Total Students</th>
                                <th>Appeared</th>
                                <th>Passed</th>
                                <th>Failed</th>
                                <th>Pass %</th>
                                <th>Average %</th>
                                <th>Highest</th>
                                <th>Lowest</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($deptStats as $dept): 
                                $appeared = $dept['students_appeared'];
                                $passed = $dept['students_passed'];
                                $passRate = ($appeared > 0) ? round(($passed / $appeared) * 100, 1) : 0.00;
                            ?>
                            <tr>
                                <td class="fw-bold"><?php echo htmlspecialchars($dept['department_name']); ?></td>
                                <td><?php echo $dept['total_students']; ?></td>
                                <td><?php echo $dept['students_appeared']; ?></td>
                                <td><span class="badge-pass"><?php echo $dept['students_passed']; ?></span></td>
                                <td><span class="badge-fail"><?php echo $dept['students_failed']; ?></span></td>
                                <td class="fw-bold text-success"><?php echo $passRate; ?>%</td>
                                <td class="fw-bold text-primary"><?php echo $dept['avg_percentage'] ? $dept['avg_percentage'] : '0.00'; ?>%</td>
                                <td class="fw-bold text-warning"><?php echo $dept['highest_score'] ? $dept['highest_score'] : '0.00'; ?>%</td>
                                <td class="fw-bold text-danger"><?php echo $dept['lowest_score'] ? $dept['lowest_score'] : '0.00'; ?>%</td>
                            </tr>
                            <?php endforeach; ?>
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
