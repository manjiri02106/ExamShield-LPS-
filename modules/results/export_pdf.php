<?php
/**
 * ==========================================
 * ExamShield LPS - Results Modules PDF Export
 * ==========================================
 */

require_once(__DIR__ . '/database.php');

$resultId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$deptFilter = isset($_GET['department_id']) ? (int)$_GET['department_id'] : 0;
$examFilter = isset($_GET['exam_id']) ? (int)$_GET['exam_id'] : 0;
$isAttendance = isset($_GET['attendance']) ? true : false;
$isDeptReport = isset($_GET['department_report']) ? true : false;

if ($resultId > 0) {
    header("Location: marksheet.php?id={$resultId}&print=1");
    exit;
}

$reportTitle = "Academic Results Report";
if ($isAttendance) $reportTitle = "Exam Attendance Log Report";
if ($isDeptReport) $reportTitle = "Department Performance Report";

// For attendance report
if ($isAttendance) {
    $list = dbFetchAll("
        SELECT 
            a.attendance_status, a.login_time, a.logout_time, a.duration,
            s.student_name, s.enrollment_no, d.department_name, e.exam_name
        FROM attendance a
        JOIN students s ON a.student_id = s.student_id
        JOIN departments d ON s.department_id = d.department_id
        JOIN exams e ON a.exam_id = e.exam_id
        ORDER BY a.attendance_id DESC
    ");
} elseif ($isDeptReport) {
    $list = dbFetchAll("
        SELECT 
            d.department_name,
            COUNT(DISTINCT s.student_id) as total_students,
            COUNT(r.result_id) as students_appeared,
            SUM(CASE WHEN r.status = 'Pass' THEN 1 ELSE 0 END) as students_passed,
            SUM(CASE WHEN r.status = 'Fail' THEN 1 ELSE 0 END) as students_failed,
            ROUND(AVG(r.percentage), 2) as avg_percentage
        FROM departments d
        LEFT JOIN students s ON s.department_id = d.department_id
        LEFT JOIN results r ON r.student_id = s.student_id
        GROUP BY d.department_id, d.department_name
    ");
} else {
    $where = ["1=1"];
    $params = [];
    if ($deptFilter > 0) { $where[] = "s.department_id = ?"; $params[] = $deptFilter; }
    if ($examFilter > 0) { $where[] = "r.exam_id = ?"; $params[] = $examFilter; }
    $whereClause = implode(" AND ", $where);
    
    $list = dbFetchAll("
        SELECT 
            r.result_id as id, r.marks_obtained, r.total_marks, r.percentage, r.status,
            s.student_name, s.enrollment_no, d.department_name, e.exam_name
        FROM results r
        JOIN students s ON r.student_id = s.student_id
        JOIN departments d ON s.department_id = d.department_id
        JOIN exams e ON r.exam_id = e.exam_id
        WHERE {$whereClause}
        ORDER BY r.result_id DESC
    ", $params);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $reportTitle; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-family: sans-serif; background: #fff; padding: 20px; color: #000; }
        .header-print { text-align: center; border-bottom: 2px solid #000; padding-bottom: 12px; margin-bottom: 20px; }
        @media print { .no-print { display: none !important; } }
    </style>
</head>
<body>

<div class="no-print mb-3 d-flex justify-content-between align-items-center">
    <button onclick="window.close()" class="btn btn-secondary btn-sm">Close</button>
    <button onclick="window.print()" class="btn btn-primary btn-sm">Print / Download PDF</button>
</div>

<div class="header-print">
    <h2 class="fw-bold mb-0">EXAMSHIELD ACADEMIC SYSTEM</h2>
    <h4 class="text-uppercase text-secondary mb-1"><?php echo $reportTitle; ?></h4>
    <small class="text-muted">Generated Date: <?php echo date("Y-m-d H:i:s"); ?></small>
</div>

<?php if ($isAttendance): ?>
<table class="table table-bordered align-middle">
    <thead class="table-light">
        <tr><th>#</th><th>Student Name</th><th>Enrollment No</th><th>Department</th><th>Exam</th><th>Status</th><th>Login</th><th>Logout</th><th>Duration</th></tr>
    </thead>
    <tbody>
        <?php if (!empty($list)): $i = 1; foreach ($list as $row): ?>
        <tr>
            <td><?php echo $i++; ?></td>
            <td class="fw-bold"><?php echo htmlspecialchars($row['student_name']); ?></td>
            <td><?php echo htmlspecialchars($row['enrollment_no']); ?></td>
            <td><?php echo htmlspecialchars($row['department_name']); ?></td>
            <td><?php echo htmlspecialchars($row['exam_name']); ?></td>
            <td class="fw-bold <?php echo $row['attendance_status'] === 'Present' ? 'text-success' : 'text-danger'; ?>"><?php echo $row['attendance_status']; ?></td>
            <td><?php echo $row['login_time'] ? $row['login_time'] : '-'; ?></td>
            <td><?php echo $row['logout_time'] ? $row['logout_time'] : '-'; ?></td>
            <td><?php echo $row['duration']; ?> mins</td>
        </tr>
        <?php endforeach; else: ?>
        <tr><td colspan="9" class="text-center py-4">No records found.</td></tr>
        <?php endif; ?>
    </tbody>
</table>

<?php elseif ($isDeptReport): ?>
<table class="table table-bordered align-middle">
    <thead class="table-light">
        <tr><th>#</th><th>Department</th><th>Total Students</th><th>Appeared</th><th>Passed</th><th>Failed</th><th>Average %</th></tr>
    </thead>
    <tbody>
        <?php if (!empty($list)): $i = 1; foreach ($list as $row): ?>
        <tr>
            <td><?php echo $i++; ?></td>
            <td class="fw-bold"><?php echo htmlspecialchars($row['department_name']); ?></td>
            <td><?php echo $row['total_students']; ?></td>
            <td><?php echo $row['students_appeared']; ?></td>
            <td class="text-success fw-bold"><?php echo $row['students_passed']; ?></td>
            <td class="text-danger fw-bold"><?php echo $row['students_failed']; ?></td>
            <td class="fw-bold"><?php echo $row['avg_percentage'] ? $row['avg_percentage'] : '0.00'; ?>%</td>
        </tr>
        <?php endforeach; else: ?>
        <tr><td colspan="7" class="text-center py-4">No records found.</td></tr>
        <?php endif; ?>
    </tbody>
</table>

<?php else: ?>
<table class="table table-bordered align-middle">
    <thead class="table-light">
        <tr><th>#</th><th>Student Name</th><th>Enrollment No</th><th>Department</th><th>Exam Name</th><th>Obtained Marks</th><th>Total Marks</th><th>Percentage</th><th>Status</th></tr>
    </thead>
    <tbody>
        <?php if (!empty($list)): $i = 1; foreach ($list as $row): ?>
        <tr>
            <td><?php echo $i++; ?></td>
            <td class="fw-bold"><?php echo htmlspecialchars($row['student_name']); ?></td>
            <td><?php echo htmlspecialchars($row['enrollment_no']); ?></td>
            <td><?php echo htmlspecialchars($row['department_name']); ?></td>
            <td><?php echo htmlspecialchars($row['exam_name']); ?></td>
            <td><?php echo number_format($row['marks_obtained'], 2); ?></td>
            <td><?php echo number_format($row['total_marks'], 2); ?></td>
            <td class="fw-bold"><?php echo number_format($row['percentage'], 2); ?>%</td>
            <td class="fw-bold <?php echo $row['status'] === 'Pass' ? 'text-success' : 'text-danger'; ?>"><?php echo strtoupper($row['status']); ?></td>
        </tr>
        <?php endforeach; else: ?>
        <tr><td colspan="9" class="text-center py-4">No records found.</td></tr>
        <?php endif; ?>
    </tbody>
</table>
<?php endif; ?>

<div class="row mt-5 pt-3 text-center">
    <div class="col-6"><p class="mb-0">Prepared By: Exam Cell</p></div>
    <div class="col-6"><p class="mb-0">Authorized Signatory: Controller of Exams</p></div>
</div>
</body>
</html>
