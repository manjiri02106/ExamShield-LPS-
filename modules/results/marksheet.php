<?php
/**
 * ==========================================
 * ExamShield LPS - Module 2: Official Marksheet View
 * ==========================================
 */

$pageTitle = "Official Marksheet - ExamShield LPS";
require_once(__DIR__ . '/database.php');

$resultId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$autoPrint = isset($_GET['print']) && $_GET['print'] == 1;

$result = null;
if ($resultId > 0) {
    $result = dbFetchOne("
        SELECT 
            r.result_id as id, r.marks_obtained, r.total_marks, r.percentage, r.status as result_status,
            s.student_name, s.enrollment_no, s.email,
            d.department_name,
            e.exam_name, e.exam_date
        FROM results r
        JOIN students s ON r.student_id = s.student_id
        JOIN departments d ON s.department_id = d.department_id
        JOIN exams e ON r.exam_id = e.exam_id
        WHERE r.result_id = ?
    ", [$resultId]);
}

if (!$result) {
    $result = dbFetchOne("
        SELECT 
            r.result_id as id, r.marks_obtained, r.total_marks, r.percentage, r.status as result_status,
            s.student_name, s.enrollment_no, s.email,
            d.department_name,
            e.exam_name, e.exam_date
        FROM results r
        JOIN students s ON r.student_id = s.student_id
        JOIN departments d ON s.department_id = d.department_id
        JOIN exams e ON r.exam_id = e.exam_id
        LIMIT 1
    ");
}
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
    <style>
        @media print {
            .sidebar, .top-header, .no-print { display: none !important; }
            .app-wrapper { height: auto; overflow: visible; }
            .main-content { overflow: visible; }
            .content-area { overflow: visible; padding: 0 !important; }
            .marksheet-card { border: 2px solid #000 !important; box-shadow: none !important; }
        }
        .marksheet-card { background: #fff; border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.08); max-width: 800px; margin: 0 auto; }
    </style>
</head>
<body>

<div class="app-wrapper">
    <aside class="sidebar no-print" id="sidebar">
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
        <header class="top-header no-print">
            <div class="header-left"><button class="mobile-toggle" id="sidebarToggle"><i class="fas fa-bars"></i></button><h2 class="breadcrumb-title">Official Marksheet</h2></div>
            <div class="header-right">
                <div class="search-box"><i class="fas fa-search"></i><input type="text" placeholder="Search..."></div>
                <a href="#" class="notification-icon"><i class="fas fa-bell"></i><span class="notification-badge"></span></a>
                <div class="user-profile"><div class="avatar">A</div><div class="d-none d-sm-block"><div style="font-size: 0.85rem; font-weight: 600; line-height: 1;">Admin User</div><span class="text-muted" style="font-size: 0.7rem;">Administrator</span></div></div>
            </div>
        </header>

        <main class="content-area">
            <div class="d-flex justify-content-between align-items-center mb-4 no-print" style="max-width: 800px; margin: 0 auto;">
                <button onclick="history.back()" class="btn btn-outline-secondary btn-sm"><i class="fas fa-arrow-left me-1"></i> Back</button>
                <div class="d-flex gap-2">
                    <button onclick="window.print()" class="btn btn-primary btn-sm"><i class="fas fa-print me-1"></i> Print</button>
                    <a href="export_pdf.php?id=<?php echo $result ? $result['id'] : 0; ?>" target="_blank" class="btn btn-danger btn-sm"><i class="fas fa-file-pdf me-1"></i> PDF</a>
                </div>
            </div>

            <?php if ($result): ?>
            <div class="marksheet-card p-5">
                <div class="text-center pb-4 mb-4 border-bottom border-2">
                    <div class="d-flex align-items-center justify-content-center gap-3 mb-2">
                        <div class="bg-primary text-white p-2 rounded fs-3" style="width: 48px; height: 48px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-graduation-cap"></i>
                        </div>
                        <div>
                            <h2 class="fw-bold mb-0 text-dark" style="letter-spacing: 1px;">EXAMSHIELD ACADEMIC SYSTEM</h2>
                            <span class="text-muted small">Official Student Examination Transcript</span>
                        </div>
                    </div>
                    <div class="badge bg-dark text-white px-3 py-1 mt-1">STATEMENT OF MARKS</div>
                </div>

                <div class="row g-3 mb-4 p-4 bg-light rounded border">
                    <div class="col-6">
                        <table class="table table-borderless table-sm mb-0">
                            <tr><td class="text-muted fw-semibold" style="width: 140px;">Student Name:</td><td class="fw-bold text-dark"><?php echo htmlspecialchars($result['student_name']); ?></td></tr>
                            <tr><td class="text-muted fw-semibold">Enrollment No:</td><td><code><?php echo htmlspecialchars($result['enrollment_no']); ?></code></td></tr>
                            <tr><td class="text-muted fw-semibold">Email:</td><td><?php echo htmlspecialchars($result['email']); ?></td></tr>
                        </table>
                    </div>
                    <div class="col-6">
                        <table class="table table-borderless table-sm mb-0">
                            <tr><td class="text-muted fw-semibold" style="width: 140px;">Department:</td><td class="fw-bold"><?php echo htmlspecialchars($result['department_name']); ?></td></tr>
                            <tr><td class="text-muted fw-semibold">Exam Title:</td><td class="fw-bold text-primary"><?php echo htmlspecialchars($result['exam_name']); ?></td></tr>
                            <tr><td class="text-muted fw-semibold">Exam Date:</td><td><?php echo htmlspecialchars($result['exam_date']); ?></td></tr>
                        </table>
                    </div>
                </div>

                <div class="table-responsive mb-4">
                    <table class="table table-bordered text-center align-middle">
                        <thead class="table-light">
                            <tr><th>Exam Module / Subject</th><th>Total Marks</th><th>Obtained Marks</th><th>Percentage (%)</th><th>Result Status</th></tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-start fw-bold text-dark py-3"><?php echo htmlspecialchars($result['exam_name']); ?></td>
                                <td class="py-3"><?php echo number_format($result['total_marks'], 2); ?></td>
                                <td class="py-3 fw-bold fs-5 text-primary"><?php echo number_format($result['marks_obtained'], 2); ?></td>
                                <td class="py-3 fw-bold fs-5 text-dark"><?php echo number_format($result['percentage'], 2); ?>%</td>
                                <td class="py-3">
                                    <?php if ($result['result_status'] === 'Pass'): ?>
                                        <span class="badge-pass px-3 py-2 fs-6">PASS</span>
                                    <?php else: ?>
                                        <span class="badge-fail px-3 py-2 fs-6">FAIL</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="row align-items-center mb-5 p-3 rounded border bg-light">
                    <div class="col-8">
                        <h6 class="fw-bold mb-1"><i class="fas fa-info-circle text-primary me-1"></i> Grading Policy</h6>
                        <small class="text-muted">Minimum pass criteria requires a score percentage &ge; 40%. Evaluated by ExamShield Engine.</small>
                    </div>
                    <div class="col-4 text-end">
                        <span class="text-muted small d-block">Final Outcome</span>
                        <strong class="fs-4 <?php echo $result['result_status'] === 'Pass' ? 'text-success' : 'text-danger'; ?>"><?php echo strtoupper($result['result_status']); ?></strong>
                    </div>
                </div>

                <div class="row pt-5 border-top text-center mt-5">
                    <div class="col-4"><hr class="w-75 mx-auto my-1"><small class="text-muted fw-semibold">Class Incharge</small></div>
                    <div class="col-4"><div class="badge bg-success bg-opacity-10 text-success border px-3 py-1 mb-1">VERIFIED</div><hr class="w-75 mx-auto my-1"><small class="text-muted fw-semibold">Controller of Examinations</small></div>
                    <div class="col-4"><hr class="w-75 mx-auto my-1"><small class="text-muted fw-semibold">Principal / Director</small></div>
                </div>
            </div>
            <?php else: ?>
            <div class="alert alert-warning">Result not found.</div>
            <?php endif; ?>
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/results.js"></script>
<?php if ($autoPrint): ?>
<script>window.onload = function() { window.print(); };</script>
<?php endif; ?>
</body>
</html>
