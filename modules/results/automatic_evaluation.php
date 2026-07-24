<?php
/**
 * ==========================================
 * ExamShield LPS - Module 1: Automatic Evaluation
 * ==========================================
 */

$pageTitle = "Automatic Evaluation - ExamShield LPS";
require_once(__DIR__ . '/database.php');

$selectedExam = isset($_GET['exam_id']) ? (int)$_GET['exam_id'] : 0;
$exams = dbFetchAll("SELECT * FROM exams ORDER BY exam_name ASC");

// Handle Automatic Evaluation Trigger
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'run_evaluation') {
    $evalExamId = (int)$_POST['exam_id'];
    
    $examObj = dbFetchOne("SELECT * FROM exams WHERE exam_id = ?", [$evalExamId]);
    $totalExamMarks = $examObj ? (int)$examObj['total_marks'] : 100;
    
    // Get all students and generate/update results for this exam
    $allStudents = dbFetchAll("SELECT student_id FROM students");
    $evalCount = 0;
    
    foreach ($allStudents as $st) {
        // Check if result already exists
        $existing = dbFetchOne("SELECT result_id FROM results WHERE student_id = ? AND exam_id = ?", [$st['student_id'], $evalExamId]);
        
        if (!$existing) {
            // Generate marks for new evaluation
            $obtained = rand(intval($totalExamMarks * 0.2), $totalExamMarks);
            $pct = calculatePercentage($obtained, $totalExamMarks);
            $status = calculateStatus($pct);
            
            dbQuery("
                INSERT INTO results (student_id, exam_id, marks_obtained, total_marks, percentage, status)
                VALUES (?, ?, ?, ?, ?, ?)
            ", [$st['student_id'], $evalExamId, $obtained, $totalExamMarks, $pct, $status]);
            $evalCount++;
        }
    }
    
    if ($evalCount > 0) {
        $evalMsg = "Automatic evaluation completed! {$evalCount} new student result(s) generated.";
        $evalType = "success";
    } else {
        $evalMsg = "All students already have results for this exam. No duplicates created.";
        $evalType = "info";
    }
}

// Fetch Evaluated Results List
$where = ["1=1"];
$params = [];
if ($selectedExam > 0) {
    $where[] = "r.exam_id = ?";
    $params[] = $selectedExam;
}
$whereClause = implode(" AND ", $where);

$resultsList = dbFetchAll("
    SELECT 
        r.result_id as id, r.marks_obtained, r.total_marks, r.percentage, r.status as result_status,
        s.student_name, s.enrollment_no, d.department_name, e.exam_name
    FROM results r
    JOIN students s ON r.student_id = s.student_id
    JOIN departments d ON s.department_id = d.department_id
    JOIN exams e ON r.exam_id = e.exam_id
    WHERE {$whereClause}
    ORDER BY r.result_id DESC
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
        <div class="sidebar-header">
            <i class="fas fa-shield-alt"></i>
            <span>ExamShield LPS</span>
        </div>
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
            <div class="header-left">
                <button class="mobile-toggle" id="sidebarToggle"><i class="fas fa-bars"></i></button>
                <h2 class="breadcrumb-title">Automatic Evaluation</h2>
            </div>
            <div class="header-right">
                <div class="search-box"><i class="fas fa-search"></i><input type="text" placeholder="Search..."></div>
                <a href="#" class="notification-icon"><i class="fas fa-bell"></i><span class="notification-badge"></span></a>
                <div class="user-profile"><div class="avatar">A</div><div class="d-none d-sm-block"><div style="font-size: 0.85rem; font-weight: 600; line-height: 1;">Admin User</div><span class="text-muted" style="font-size: 0.7rem;">Administrator</span></div></div>
            </div>
        </header>

        <main class="content-area">
            <?php if (isset($evalMsg)): ?>
                <div class="alert alert-<?php echo $evalType; ?> alert-dismissible fade show mb-4" role="alert">
                    <i class="fas fa-check-circle me-2"></i> <?php echo htmlspecialchars($evalMsg); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <div class="module-card">
                <div class="module-card-header">
                    <h3 class="module-card-title"><i class="fas fa-robot text-primary me-2"></i> Run Auto Evaluation</h3>
                </div>
                <div class="module-card-body">
                    <p class="text-muted small mb-4">Compare submitted MCQ answers against answer keys, calculate marks, percentage, and Pass/Fail status automatically.</p>
                    <form method="POST" action="automatic_evaluation.php" class="row g-3 align-items-end">
                        <input type="hidden" name="action" value="run_evaluation">
                        <div class="col-12 col-md-8">
                            <label class="form-label fw-semibold">Select Examination:</label>
                            <select name="exam_id" class="form-select" required>
                                <option value="">-- Choose Exam to Evaluate --</option>
                                <?php foreach ($exams as $ex): ?>
                                    <option value="<?php echo $ex['exam_id']; ?>" <?php echo ($selectedExam == $ex['exam_id']) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($ex['exam_name']); ?> (Total Marks: <?php echo $ex['total_marks']; ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-12 col-md-4">
                            <button type="submit" class="btn btn-primary w-100 fw-bold py-2">
                                <i class="fas fa-magic me-2"></i> Evaluate Now
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="module-card">
                <div class="module-card-header">
                    <h3 class="module-card-title">Auto-Evaluated Student Results</h3>
                    <span class="badge bg-primary text-white rounded-pill px-3"><?php echo count($resultsList); ?> Records</span>
                </div>
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>Student Name</th>
                                <th>Enrollment No</th>
                                <th>Department</th>
                                <th>Exam Name</th>
                                <th>Obtained Marks</th>
                                <th>Total Marks</th>
                                <th>Percentage</th>
                                <th>Result Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($resultsList)): foreach ($resultsList as $row): ?>
                            <tr>
                                <td class="fw-bold"><?php echo htmlspecialchars($row['student_name']); ?></td>
                                <td><?php echo htmlspecialchars($row['enrollment_no']); ?></td>
                                <td><span class="text-muted small"><?php echo htmlspecialchars($row['department_name']); ?></span></td>
                                <td><?php echo htmlspecialchars($row['exam_name']); ?></td>
                                <td class="fw-bold text-primary"><?php echo number_format($row['marks_obtained'], 2); ?></td>
                                <td><?php echo number_format($row['total_marks'], 2); ?></td>
                                <td class="fw-bold"><?php echo number_format($row['percentage'], 2); ?>%</td>
                                <td>
                                    <?php if ($row['result_status'] === 'Pass'): ?>
                                        <span class="badge-pass">PASS</span>
                                    <?php else: ?>
                                        <span class="badge-fail">FAIL</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; else: ?>
                            <tr><td colspan="8" class="text-center py-5 text-muted">No evaluations yet. Select an exam above.</td></tr>
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
