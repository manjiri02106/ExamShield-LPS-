<?php
/**
 * ==========================================
 * ExamShield LPS - Chart Data JSON Endpoint
 * ==========================================
 */
header('Content-Type: application/json');
require_once(__DIR__ . '/database.php');

$response = [
    'monthly_performance' => ['labels' => [], 'data' => []],
    'pass_vs_fail' => ['labels' => ['Pass', 'Fail'], 'data' => [0, 0]],
    'department_performance' => ['labels' => [], 'data' => []],
    'top_students' => ['labels' => [], 'data' => []]
];

// 1. Monthly Performance (Line Chart)
try {
    $monthlyStats = dbFetchAll("
        SELECT DATE_FORMAT(e.exam_date, '%b %Y') as month_name, ROUND(AVG(r.percentage), 2) as avg_score 
        FROM results r 
        JOIN exams e ON r.exam_id = e.exam_id 
        GROUP BY month_name
        ORDER BY MIN(e.exam_date) ASC 
        LIMIT 12
    ");
    if (!empty($monthlyStats)) {
        foreach ($monthlyStats as $ms) {
            $response['monthly_performance']['labels'][] = $ms['month_name'];
            $response['monthly_performance']['data'][] = (float)$ms['avg_score'];
        }
    } else {
        $response['monthly_performance']['labels'] = ['No Data'];
        $response['monthly_performance']['data'] = [0];
    }
} catch (Exception $e) {
    $response['monthly_performance']['labels'] = ['Error'];
    $response['monthly_performance']['data'] = [0];
}

// 2. Pass vs Fail (Doughnut Chart)
try {
    $passCount = dbFetchOne("SELECT COUNT(*) as count FROM results WHERE status = 'Pass'")['count'] ?? 0;
    $failCount = dbFetchOne("SELECT COUNT(*) as count FROM results WHERE status = 'Fail'")['count'] ?? 0;
    if ($passCount == 0 && $failCount == 0) {
        $response['pass_vs_fail']['data'] = [0, 0];
    } else {
        $response['pass_vs_fail']['data'] = [(int)$passCount, (int)$failCount];
    }
} catch (Exception $e) {
    $response['pass_vs_fail']['data'] = [0, 0];
}

// 3. Department Performance (Bar Chart)
try {
    $deptStats = dbFetchAll("
        SELECT d.department_name, 
               COUNT(r.result_id) as total_appeared,
               SUM(CASE WHEN r.status = 'Pass' THEN 1 ELSE 0 END) as pass_count
        FROM departments d
        LEFT JOIN students s ON s.department_id = d.department_id
        LEFT JOIN results r ON r.student_id = s.student_id
        GROUP BY d.department_id, d.department_name
        HAVING total_appeared > 0
        ORDER BY pass_count DESC
        LIMIT 6
    ");
    if (!empty($deptStats)) {
        foreach ($deptStats as $ds) {
            $response['department_performance']['labels'][] = $ds['department_name'];
            $passPct = round(($ds['pass_count'] / $ds['total_appeared']) * 100, 1);
            $response['department_performance']['data'][] = $passPct;
        }
    } else {
        $response['department_performance']['labels'] = ['No Data'];
        $response['department_performance']['data'] = [0];
    }
} catch (Exception $e) {
    $response['department_performance']['labels'] = ['Error'];
    $response['department_performance']['data'] = [0];
}

// 4. Top Students (Horizontal Bar Chart)
try {
    $topStats = dbFetchAll("
        SELECT s.student_name, r.percentage
        FROM results r
        JOIN students s ON r.student_id = s.student_id
        ORDER BY r.percentage DESC
        LIMIT 5
    ");
    if (!empty($topStats)) {
        foreach ($topStats as $ts) {
            $response['top_students']['labels'][] = $ts['student_name'];
            $response['top_students']['data'][] = (float)$ts['percentage'];
        }
    } else {
        $response['top_students']['labels'] = ['No Data'];
        $response['top_students']['data'] = [0];
    }
} catch (Exception $e) {
    $response['top_students']['labels'] = ['Error'];
    $response['top_students']['data'] = [0];
}

echo json_encode($response);
