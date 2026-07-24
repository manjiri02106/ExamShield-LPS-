<?php
/**
 * ==========================================
 * ExamShield LPS - Results Modules Excel Export
 * ==========================================
 */

require_once(__DIR__ . '/database.php');

$deptFilter = isset($_GET['department_id']) ? (int)$_GET['department_id'] : 0;
$examFilter = isset($_GET['exam_id']) ? (int)$_GET['exam_id'] : 0;
$isDeptReport = isset($_GET['department_report']) ? true : false;
$isAttendance = isset($_GET['attendance']) ? true : false;

$filename = "examshield_results_" . date("Ymd_His") . ".xls";

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=\"$filename\"");

if ($isDeptReport):
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
?>
<table border="1">
    <thead>
        <tr style="background-color: #2563eb; color: #fff;">
            <th>Department Name</th><th>Total Students</th><th>Students Appeared</th><th>Passed</th><th>Failed</th><th>Average Percentage (%)</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($deptStats as $ds): ?>
        <tr>
            <td><?php echo htmlspecialchars($ds['department_name']); ?></td>
            <td><?php echo $ds['total_students']; ?></td>
            <td><?php echo $ds['students_appeared']; ?></td>
            <td><?php echo $ds['students_passed']; ?></td>
            <td><?php echo $ds['students_failed']; ?></td>
            <td><?php echo $ds['avg_percentage'] ? $ds['avg_percentage'] : '0.00'; ?>%</td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php elseif ($isAttendance):
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
?>
<table border="1">
    <thead>
        <tr style="background-color: #10b981; color: #fff;">
            <th>Student Name</th><th>Enrollment No</th><th>Department</th><th>Exam Name</th><th>Status</th><th>Login Time</th><th>Logout Time</th><th>Duration (mins)</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($attList as $att): ?>
        <tr>
            <td><?php echo htmlspecialchars($att['student_name']); ?></td>
            <td><?php echo htmlspecialchars($att['enrollment_no']); ?></td>
            <td><?php echo htmlspecialchars($att['department_name']); ?></td>
            <td><?php echo htmlspecialchars($att['exam_name']); ?></td>
            <td><?php echo $att['attendance_status']; ?></td>
            <td><?php echo $att['login_time']; ?></td>
            <td><?php echo $att['logout_time']; ?></td>
            <td><?php echo $att['duration']; ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php else:
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
?>
<table border="1">
    <thead>
        <tr style="background-color: #0f172a; color: #fff;">
            <th>Student Name</th><th>Enrollment Number</th><th>Department</th><th>Exam Name</th><th>Obtained Marks</th><th>Total Marks</th><th>Percentage (%)</th><th>Result Status</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($list as $row): ?>
        <tr>
            <td><?php echo htmlspecialchars($row['student_name']); ?></td>
            <td><?php echo htmlspecialchars($row['enrollment_no']); ?></td>
            <td><?php echo htmlspecialchars($row['department_name']); ?></td>
            <td><?php echo htmlspecialchars($row['exam_name']); ?></td>
            <td><?php echo number_format($row['marks_obtained'], 2); ?></td>
            <td><?php echo number_format($row['total_marks'], 2); ?></td>
            <td><?php echo number_format($row['percentage'], 2); ?>%</td>
            <td><?php echo $row['status']; ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php endif; exit; ?>
