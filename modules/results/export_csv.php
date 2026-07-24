<?php
/**
 * ==========================================
 * ExamShield LPS - Results Modules CSV Export
 * ==========================================
 */

require_once(__DIR__ . '/database.php');

$deptFilter = isset($_GET['department_id']) ? (int)$_GET['department_id'] : 0;
$examFilter = isset($_GET['exam_id']) ? (int)$_GET['exam_id'] : 0;
$isDeptReport = isset($_GET['department_report']) ? true : false;
$isAttendance = isset($_GET['attendance']) ? true : false;

$filename = "examshield_export_" . date("Ymd_His") . ".csv";

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename="' . $filename . '"');

$output = fopen('php://output', 'w');

if ($isDeptReport) {
    fputcsv($output, ['Department Name', 'Total Students', 'Students Appeared', 'Passed', 'Failed', 'Average Percentage (%)']);
    $deptStats = dbFetchAll("
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
    foreach ($deptStats as $ds) {
        fputcsv($output, [
            $ds['department_name'], $ds['total_students'], $ds['students_appeared'],
            $ds['students_passed'], $ds['students_failed'],
            ($ds['avg_percentage'] ? $ds['avg_percentage'] : '0.00') . '%'
        ]);
    }
    fclose($output);
    exit;
}

if ($isAttendance) {
    fputcsv($output, ['Student Name', 'Enrollment Number', 'Department', 'Exam Name', 'Attendance Status', 'Login Time', 'Logout Time', 'Duration (Minutes)']);
    $attList = dbFetchAll("
        SELECT 
            a.attendance_status, a.login_time, a.logout_time, a.duration,
            s.student_name, s.enrollment_no, d.department_name, e.exam_name
        FROM attendance a
        JOIN students s ON a.student_id = s.student_id
        JOIN departments d ON s.department_id = d.department_id
        JOIN exams e ON a.exam_id = e.exam_id
        ORDER BY a.attendance_id DESC
    ");
    foreach ($attList as $att) {
        fputcsv($output, [
            $att['student_name'], $att['enrollment_no'], $att['department_name'], $att['exam_name'],
            $att['attendance_status'], $att['login_time'], $att['logout_time'], $att['duration']
        ]);
    }
    fclose($output);
    exit;
}

// Standard Results Export
fputcsv($output, ['Student Name', 'Enrollment Number', 'Department', 'Exam Name', 'Marks Obtained', 'Total Marks', 'Percentage (%)', 'Result Status']);

$where = ["1=1"];
$params = [];
if ($deptFilter > 0) { $where[] = "s.department_id = ?"; $params[] = $deptFilter; }
if ($examFilter > 0) { $where[] = "r.exam_id = ?"; $params[] = $examFilter; }
$whereClause = implode(" AND ", $where);

$list = dbFetchAll("
    SELECT 
        s.student_name, s.enrollment_no, d.department_name, e.exam_name,
        r.marks_obtained, r.total_marks, r.percentage, r.status
    FROM results r
    JOIN students s ON r.student_id = s.student_id
    JOIN departments d ON s.department_id = d.department_id
    JOIN exams e ON r.exam_id = e.exam_id
    WHERE {$whereClause}
    ORDER BY r.result_id DESC
", $params);

foreach ($list as $row) {
    fputcsv($output, [
        $row['student_name'], $row['enrollment_no'], $row['department_name'], $row['exam_name'],
        $row['marks_obtained'], $row['total_marks'],
        number_format($row['percentage'], 2) . '%', $row['status']
    ]);
}

fclose($output);
exit;
