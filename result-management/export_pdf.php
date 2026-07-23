<?php
/**
 * ==========================================
 * Student Result Management & Reports
 * Export PDF Handler (Printable Formatted HTML/PDF)
 * ==========================================
 */

require_once(__DIR__ . '/database.php');

$resultId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$examFilter = isset($_GET['exam_id']) ? (int)$_GET['exam_id'] : 0;
$deptFilter = isset($_GET['department_id']) ? (int)$_GET['department_id'] : 0;
$isToppers = isset($_GET['toppers']) ? true : false;
$isFailed = isset($_GET['failed']) ? true : false;
$isDeptReport = isset($_GET['department_report']) ? true : false;
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

// Single Marksheet PDF Export
if ($resultId > 0) {
    header("Location: marksheet.php?id=" . $resultId);
    exit;
}

// Build query
$where = ["1=1"];
$params = [];

if ($isToppers) {
    $where[] = "r.status = 'Pass'";
} elseif ($isFailed) {
    $where[] = "r.status = 'Fail'";
}

if ($examFilter > 0) {
    $where[] = "r.exam_id = ?";
    $params[] = $examFilter;
}

if ($deptFilter > 0) {
    $where[] = "s.department_id = ?";
    $params[] = $deptFilter;
}

if (!empty($search)) {
    $where[] = "(s.name LIKE ? OR s.enrollment_no LIKE ?)";
    $searchTerm = "%{$search}%";
    $params[] = $searchTerm;
    $params[] = $searchTerm;
}

$whereClause = implode(" AND ", $where);

$orderBy = "r.id DESC";
if ($isToppers) $orderBy = "r.percentage DESC";
if ($isFailed) $orderBy = "r.percentage ASC";

$sql = "
    SELECT 
        r.id, r.marks, r.total_marks, r.percentage, r.status, r.created_at,
        s.name as student_name, s.enrollment_no,
        d.department_name, d.department_code,
        e.exam_name
    FROM results r
    JOIN students s ON r.student_id = s.id
    JOIN departments d ON s.department_id = d.id
    JOIN exams e ON r.exam_id = e.id
    WHERE {$whereClause}
    ORDER BY {$orderBy}
";
$list = dbFetchAll($sql, $params);

$reportTitle = "Student Results Official Report";
if ($isToppers) $reportTitle = "Top Performers & Merit List Report";
if ($isFailed) $reportTitle = "Failed Students Academic Remediation Report";
if ($isDeptReport) $reportTitle = "Department Wise Performance Report";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $reportTitle; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #fff; color: #000; padding: 20px; }
        .report-header { text-align: center; border-bottom: 2px solid #000; padding-bottom: 15px; margin-bottom: 25px; }
        .table th { background-color: #f2f2f2 !important; color: #000 !important; }
        @media print {
            .no-print { display: none !important; }
        }
    </style>
</head>
<body>

<div class="no-print mb-4 d-flex justify-content-between align-items-center">
    <button onclick="window.close()" class="btn btn-secondary btn-sm">Close Window</button>
    <button onclick="window.print()" class="btn btn-primary btn-sm">Print / Download PDF</button>
</div>

<div class="report-header">
    <h2 class="fw-bold mb-1">EXAMSHIELD ACADEMIC SYSTEM</h2>
    <h4 class="text-uppercase text-secondary mb-1"><?php echo $reportTitle; ?></h4>
    <small>Generated Date: <?php echo date("Y-m-d H:i:s"); ?></small>
</div>

<?php if ($isDeptReport): 
    $deptStats = dbFetchAll("
        SELECT 
            d.department_name, d.department_code,
            COUNT(DISTINCT s.id) as total_students,
            COUNT(r.id) as total_results,
            SUM(CASE WHEN r.status = 'Pass' THEN 1 ELSE 0 END) as pass_count,
            SUM(CASE WHEN r.status = 'Fail' THEN 1 ELSE 0 END) as fail_count,
            ROUND(AVG(r.percentage), 2) as avg_percentage
        FROM departments d
        LEFT JOIN students s ON s.department_id = d.id
        LEFT JOIN results r ON r.student_id = s.id
        GROUP BY d.id
    ");
?>
<table class="table table-bordered align-middle">
    <thead>
        <tr>
            <th>Department Name</th>
            <th>Code</th>
            <th>Total Students</th>
            <th>Total Exams</th>
            <th>Pass Count</th>
            <th>Fail Count</th>
            <th>Average Score (%)</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($deptStats as $ds): ?>
        <tr>
            <td><?php echo htmlspecialchars($ds['department_name']); ?></td>
            <td><?php echo htmlspecialchars($ds['department_code']); ?></td>
            <td><?php echo $ds['total_students']; ?></td>
            <td><?php echo $ds['total_results']; ?></td>
            <td class="text-success fw-bold"><?php echo $ds['pass_count']; ?></td>
            <td class="text-danger fw-bold"><?php echo $ds['fail_count']; ?></td>
            <td class="fw-bold"><?php echo $ds['avg_percentage'] ? $ds['avg_percentage'] : '0.00'; ?>%</td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php else: ?>

<table class="table table-bordered align-middle">
    <thead>
        <tr>
            <th>S.No</th>
            <th>Student Name</th>
            <th>Enrollment No</th>
            <th>Department</th>
            <th>Exam Name</th>
            <th>Marks Obtained</th>
            <th>Total Marks</th>
            <th>Percentage</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($list)): $sno = 1; foreach ($list as $row): ?>
        <tr>
            <td><?php echo $sno++; ?></td>
            <td class="fw-bold"><?php echo htmlspecialchars($row['student_name']); ?></td>
            <td><?php echo htmlspecialchars($row['enrollment_no']); ?></td>
            <td><?php echo htmlspecialchars($row['department_name']); ?></td>
            <td><?php echo htmlspecialchars($row['exam_name']); ?></td>
            <td><?php echo $row['marks']; ?></td>
            <td><?php echo $row['total_marks']; ?></td>
            <td class="fw-bold"><?php echo number_format($row['percentage'], 2); ?>%</td>
            <td class="fw-bold <?php echo $row['status'] === 'Pass' ? 'text-success' : 'text-danger'; ?>">
                <?php echo strtoupper($row['status']); ?>
            </td>
        </tr>
        <?php endforeach; else: ?>
        <tr>
            <td colspan="9" class="text-center py-4">No records found.</td>
        </tr>
        <?php endif; ?>
    </tbody>
</table>
<?php endif; ?>

<div class="row mt-5 pt-4 text-center">
    <div class="col-6">
        <p class="mb-0">Prepared By</p>
        <small class="text-muted">Exam Department Clerk</small>
    </div>
    <div class="col-6">
        <p class="mb-0">Authorized Signature</p>
        <small class="text-muted">Controller of Examinations</small>
    </div>
</div>

<script>
window.onload = function() {
    // Optional auto print trigger
    // window.print();
};
</script>
</body>
</html>
