<?php
/**
 * ==========================================
 * Student Result Management & Reports
 * Chart Data JSON Endpoint
 * ==========================================
 */

header('Content-Type: application/json');
require_once(__DIR__ . '/database.php');

$response = [
    'performance_overview' => [
        'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        'data' => array_fill(0, 12, 0)
    ],
    'result_summary' => [
        'labels' => ['Pass', 'Fail'],
        'data' => [0, 0]
    ],
    'department_performance' => [
        'labels' => [],
        'data' => []
    ],
    'top_students' => [
        'labels' => [],
        'data' => []
    ]
];

try {
    // 1. Monthly Performance Overview (Jan - Dec)
    $monthlyQuery = "
        SELECT 
            MONTH(created_at) as month_num, 
            ROUND(AVG(percentage), 2) as avg_score 
        FROM results 
        GROUP BY MONTH(created_at)
    ";
    $monthlyResults = dbFetchAll($monthlyQuery);
    
    // Fill monthly data
    foreach ($monthlyResults as $row) {
        $mIndex = ((int)$row['month_num']) - 1;
        if ($mIndex >= 0 && $mIndex < 12) {
            $response['performance_overview']['data'][$mIndex] = (float)$row['avg_score'];
        }
    }

    // 2. Result Summary (Pass vs Fail)
    $summaryQuery = "
        SELECT status, COUNT(*) as count 
        FROM results 
        GROUP BY status
    ";
    $summaryResults = dbFetchAll($summaryQuery);
    
    $passCount = 0;
    $failCount = 0;
    foreach ($summaryResults as $row) {
        if ($row['status'] === 'Pass') {
            $passCount = (int)$row['count'];
        } else {
            $failCount = (int)$row['count'];
        }
    }
    $response['result_summary']['data'] = [$passCount, $failCount];

    // 3. Department Wise Performance
    $deptQuery = "
        SELECT 
            d.department_code, 
            d.department_name,
            ROUND(AVG(r.percentage), 2) as avg_percentage
        FROM departments d
        LEFT JOIN students s ON s.department_id = d.id
        LEFT JOIN results r ON r.student_id = s.id
        GROUP BY d.id
        ORDER BY d.department_name ASC
    ";
    $deptResults = dbFetchAll($deptQuery);
    foreach ($deptResults as $row) {
        $response['department_performance']['labels'][] = $row['department_code'];
        $response['department_performance']['data'][] = $row['avg_percentage'] ? (float)$row['avg_percentage'] : 0;
    }

    // 4. Top 10 Performing Students
    $topQuery = "
        SELECT 
            s.name, 
            ROUND(AVG(r.percentage), 2) as avg_pct 
        FROM results r
        JOIN students s ON r.student_id = s.id
        GROUP BY r.student_id
        ORDER BY avg_pct DESC
        LIMIT 10
    ";
    $topResults = dbFetchAll($topQuery);
    foreach ($topResults as $row) {
        $response['top_students']['labels'][] = $row['name'];
        $response['top_students']['data'][] = (float)$row['avg_pct'];
    }

} catch (Exception $e) {
    // Return empty fallback structure on error
}

echo json_encode($response);
exit;
