<?php
/**
 * ==========================================
 * Student Result Management & Reports
 * Export CSV / Excel Handler
 * ==========================================
 */

require_once(__DIR__ . '/database.php');

$examFilter = isset($_GET['exam_id']) ? (int)$_GET['exam_id'] : 0;
$deptFilter = isset($_GET['department_id']) ? (int)$_GET['department_id'] : 0;
$isToppers = isset($_GET['toppers']) ? true : false;
$isFailed = isset($_GET['failed']) ? true : false;
$isDeptReport = isset($_GET['department_report']) ? true : false;
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

$filename = "student_results_" . date("Ymd_His") . ".csv";

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename="' . $filename . '"');

$output = fopen('php://output', 'w');

if ($isDeptReport) {
    // Header for Department Report
    fputcsv($output, ['Department Name', 'Department Code', 'Total Students', 'Total Exams', 'Pass Count', 'Fail Count', 'Pass Rate (%)', 'Average Percentage (%)']);

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

    foreach ($deptStats as $row) {
        $passRate = ($row['total_results'] > 0) ? round(($row['pass_count'] / $row['total_results']) * 100, 1) : 0;
        fputcsv($output, [
            $row['department_name'],
            $row['department_code'],
            $row['total_students'],
            $row['total_results'],
            $row['pass_count'],
            $row['fail_count'],
            $passRate . '%',
            ($row['avg_percentage'] ? $row['avg_percentage'] : '0.00') . '%'
        ]);
    }
    fclose($output);
    exit;
}

// Header row for Result list
fputcsv($output, ['Student Name', 'Enrollment Number', 'Department', 'Exam Name', 'Marks Obtained', 'Total Marks', 'Percentage (%)', 'Result Status']);

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
        s.name as student_name, s.enrollment_no,
        d.department_name,
        e.exam_name,
        r.marks, r.total_marks, r.percentage, r.status
    FROM results r
    JOIN students s ON r.student_id = s.id
    JOIN departments d ON s.department_id = d.id
    JOIN exams e ON r.exam_id = e.id
    WHERE {$whereClause}
    ORDER BY {$orderBy}
";
$list = dbFetchAll($sql, $params);

foreach ($list as $row) {
    fputcsv($output, [
        $row['student_name'],
        $row['enrollment_no'],
        $row['department_name'],
        $row['exam_name'],
        $row['marks'],
        $row['total_marks'],
        number_format($row['percentage'], 2) . '%',
        $row['status']
    ]);
}

fclose($output);
exit;
