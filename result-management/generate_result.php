<?php
/**
 * ==========================================
 * Student Result Management & Reports
 * Exam Wise Report & Result Summary
 * ==========================================
 */

$pageTitle = "Exam Wise Report - Student Result Management & Reports";
include(__DIR__ . '/header.php');

$examId = isset($_GET['exam_id']) ? (int)$_GET['exam_id'] : 1;
$exams = dbFetchAll("SELECT * FROM exams ORDER BY exam_name ASC");

// Fetch selected exam details
$selectedExam = dbFetchOne("SELECT * FROM exams WHERE id = ?", [$examId]);
if (!$selectedExam && !empty($exams)) {
    $selectedExam = $exams[0];
    $examId = $selectedExam['id'];
}

// Fetch exam statistics
$stats = dbFetchOne("
    SELECT 
        COUNT(*) as total_students,
        SUM(CASE WHEN status = 'Pass' THEN 1 ELSE 0 END) as pass_count,
        SUM(CASE WHEN status = 'Fail' THEN 1 ELSE 0 END) as fail_count,
        ROUND(AVG(percentage), 2) as avg_score,
        MAX(percentage) as highest_score
    FROM results 
    WHERE exam_id = ?
", [$examId]);

$totalStudents = $stats['total_students'] ?? 0;
$passCount = $stats['pass_count'] ?? 0;
$failCount = $stats['fail_count'] ?? 0;
$avgScore = $stats['avg_score'] ?? 0.00;
$highestScore = $stats['highest_score'] ?? 0.00;
$passRate = ($totalStudents > 0) ? round(($passCount / $totalStudents) * 100, 1) : 0.00;

// Fetch Top Scorer for this Exam
$topper = dbFetchOne("
    SELECT s.name, r.marks, r.percentage
    FROM results r
    JOIN students s ON r.student_id = s.id
    WHERE r.exam_id = ?
    ORDER BY r.percentage DESC
    LIMIT 1
", [$examId]);

// Fetch All Student Results for this Exam
$examResults = dbFetchAll("
    SELECT 
        r.id, r.marks, r.total_marks, r.percentage, r.status,
        s.name as student_name, s.enrollment_no,
        d.department_name, d.department_code
    FROM results r
    JOIN students s ON r.student_id = s.id
    JOIN departments d ON s.department_id = d.id
    WHERE r.exam_id = ?
    ORDER BY r.percentage DESC
", [$examId]);
?>

<!-- Header Filter Card -->
<div class="custom-card">
    <div class="card-body-custom">
        <form method="GET" action="generate_result.php" class="row g-3 align-items-center">
            <div class="col-12 col-md-8">
                <label class="form-label fw-semibold text-muted">Select Examination for Report Generation:</label>
                <select name="exam_id" class="form-select form-select-custom" onchange="this.form.submit()">
                    <?php foreach ($exams as $ex): ?>
                        <option value="<?php echo $ex['id']; ?>" <?php echo ($examId == $ex['id']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($ex['exam_name']); ?> (Date: <?php echo $ex['exam_date']; ?> | Max Marks: <?php echo $ex['total_marks']; ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-12 col-md-4 d-flex justify-content-md-end align-items-end gap-2">
                <a href="export_pdf.php?exam_id=<?php echo $examId; ?>" target="_blank" class="btn btn-outline-danger">
                    <i class="fas fa-file-pdf me-1"></i> PDF Summary
                </a>
                <a href="export_excel.php?exam_id=<?php echo $examId; ?>" class="btn btn-success-custom">
                    <i class="fas fa-file-csv me-1"></i> Export CSV
                </a>
            </div>
        </form>
    </div>
</div>

<?php if ($selectedExam): ?>
<!-- Summary KPI Cards -->
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="stat-card stat-blue">
            <div class="stat-info">
                <div class="stat-label">Total Appeared</div>
                <div class="stat-value"><?php echo $totalStudents; ?></div>
            </div>
            <div class="stat-icon"><i class="fas fa-users"></i></div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card stat-green">
            <div class="stat-info">
                <div class="stat-label">Passed Students</div>
                <div class="stat-value"><?php echo $passCount; ?> (<?php echo $passRate; ?>%)</div>
            </div>
            <div class="stat-icon"><i class="fas fa-user-check"></i></div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card stat-amber">
            <div class="stat-info">
                <div class="stat-label">Average Score</div>
                <div class="stat-value"><?php echo $avgScore; ?>%</div>
            </div>
            <div class="stat-icon"><i class="fas fa-chart-line"></i></div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card stat-purple">
            <div class="stat-info">
                <div class="stat-label">Exam Topper Score</div>
                <div class="stat-value"><?php echo $highestScore; ?>%</div>
            </div>
            <div class="stat-icon"><i class="fas fa-crown"></i></div>
        </div>
    </div>
</div>

<!-- Exam Wise Breakdown Table -->
<div class="custom-card">
    <div class="card-header-custom">
        <h3 class="card-header-title">
            <i class="fas fa-file-alt text-primary"></i> <?php echo htmlspecialchars($selectedExam['exam_name']); ?> - Result List
        </h3>
        <?php if ($topper): ?>
            <span class="badge bg-warning text-dark border"><i class="fas fa-trophy me-1"></i> Exam Topper: <?php echo htmlspecialchars($topper['name']); ?> (<?php echo $topper['percentage']; ?>%)</span>
        <?php endif; ?>
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
                        <th>Marks Obtained</th>
                        <th>Total Marks</th>
                        <th>Percentage</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($examResults)): $rank = 1; foreach ($examResults as $res): ?>
                    <tr>
                        <td class="fw-bold">
                            <?php if ($rank === 1): ?>
                                <span class="badge badge-rank-1">#1</span>
                            <?php elseif ($rank === 2): ?>
                                <span class="badge badge-rank-2">#2</span>
                            <?php elseif ($rank === 3): ?>
                                <span class="badge badge-rank-3">#3</span>
                            <?php else: ?>
                                #<?php echo $rank; ?>
                            <?php endif; ?>
                        </td>
                        <td class="fw-semibold"><?php echo htmlspecialchars($res['student_name']); ?></td>
                        <td><code><?php echo htmlspecialchars($res['enrollment_no']); ?></code></td>
                        <td><?php echo htmlspecialchars($res['department_name']); ?></td>
                        <td class="fw-bold"><?php echo $res['marks']; ?></td>
                        <td><?php echo $res['total_marks']; ?></td>
                        <td class="fw-bold text-primary"><?php echo number_format($res['percentage'], 2); ?>%</td>
                        <td>
                            <?php if ($res['status'] === 'Pass'): ?>
                                <span class="badge-status badge-pass"><i class="fas fa-check-circle"></i> Pass</span>
                            <?php else: ?>
                                <span class="badge-status badge-fail"><i class="fas fa-times-circle"></i> Fail</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="marksheet.php?id=<?php echo $res['id']; ?>" class="action-btn action-btn-view" title="Print Marksheet">
                                <i class="fas fa-file-invoice"></i>
                            </a>
                        </td>
                    </tr>
                    <?php $rank++; endforeach; else: ?>
                    <tr>
                        <td colspan="9" class="text-center py-4 text-muted">No student results generated for this exam yet.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php endif; ?>

<?php include(__DIR__ . '/footer.php'); ?>
