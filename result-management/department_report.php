<?php
/**
 * ==========================================
 * Student Result Management & Reports
 * Department Result Report & Performance Analytics
 * ==========================================
 */

$pageTitle = "Department Result Report - Student Result Management & Reports";
include(__DIR__ . '/header.php');

// Fetch Department Performance Summary
$deptStatsSql = "
    SELECT 
        d.id as department_id,
        d.department_name,
        d.department_code,
        COUNT(DISTINCT s.id) as total_students,
        COUNT(r.id) as total_results,
        SUM(CASE WHEN r.status = 'Pass' THEN 1 ELSE 0 END) as pass_count,
        SUM(CASE WHEN r.status = 'Fail' THEN 1 ELSE 0 END) as fail_count,
        ROUND(AVG(r.percentage), 2) as avg_percentage,
        MAX(r.percentage) as top_percentage
    FROM departments d
    LEFT JOIN students s ON s.department_id = d.id
    LEFT JOIN results r ON r.student_id = s.id
    GROUP BY d.id
    ORDER BY d.department_name ASC
";
$deptStats = dbFetchAll($deptStatsSql);
?>

<!-- Header Title & Export Card -->
<div class="custom-card">
    <div class="card-body-custom d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
        <div>
            <h4 class="fw-bold mb-1"><i class="fas fa-building text-primary me-2"></i> Department-Wise Academic Performance</h4>
            <p class="text-muted small mb-0">Comparative results analysis, average scores, and pass percentages by department.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="export_pdf.php?department_report=1" target="_blank" class="btn btn-outline-danger btn-sm">
                <i class="fas fa-file-pdf me-1"></i> Department PDF Report
            </a>
            <a href="export_excel.php?department_report=1" class="btn btn-success-custom btn-sm">
                <i class="fas fa-file-csv me-1"></i> Export CSV
            </a>
        </div>
    </div>
</div>

<!-- Department Cards Grid -->
<div class="row g-4 mb-4">
    <?php foreach ($deptStats as $dept): 
        $passRate = ($dept['total_results'] > 0) ? round(($dept['pass_count'] / $dept['total_results']) * 100, 1) : 0;
        $avgScore = $dept['avg_percentage'] ? $dept['avg_percentage'] : 0.00;
    ?>
    <div class="col-12 col-md-6 col-xl-4">
        <div class="custom-card h-100 mb-0">
            <div class="card-header-custom">
                <h5 class="card-header-title">
                    <span class="badge bg-primary me-2"><?php echo htmlspecialchars($dept['department_code']); ?></span>
                    <?php echo htmlspecialchars($dept['department_name']); ?>
                </h5>
            </div>
            <div class="card-body-custom">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <span class="text-muted small">Average Score</span>
                        <div class="fs-3 fw-bold text-primary"><?php echo $avgScore; ?>%</div>
                    </div>
                    <div class="text-end">
                        <span class="text-muted small">Pass Rate</span>
                        <div class="fs-4 fw-bold text-success"><?php echo $passRate; ?>%</div>
                    </div>
                </div>

                <!-- Progress Bar -->
                <div class="progress mb-3" style="height: 8px;">
                    <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo $passRate; ?>%" aria-valuenow="<?php echo $passRate; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                </div>

                <div class="row g-2 text-center pt-2 border-top">
                    <div class="col-4">
                        <div class="small text-muted">Students</div>
                        <div class="fw-bold"><?php echo $dept['total_students']; ?></div>
                    </div>
                    <div class="col-4">
                        <div class="small text-muted">Passed</div>
                        <div class="fw-bold text-success"><?php echo $dept['pass_count']; ?></div>
                    </div>
                    <div class="col-4">
                        <div class="small text-muted">Failed</div>
                        <div class="fw-bold text-danger"><?php echo $dept['fail_count']; ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<!-- Department Summary Table -->
<div class="custom-card">
    <div class="card-header-custom">
        <h3 class="card-header-title">
            <i class="fas fa-list-alt text-secondary me-2"></i> Department Performance Matrix
        </h3>
    </div>
    <div class="card-body-custom p-0">
        <div class="table-responsive">
            <table class="table custom-table mb-0">
                <thead>
                    <tr>
                        <th>Department Name</th>
                        <th>Code</th>
                        <th>Students Enrolled</th>
                        <th>Total Exams Taken</th>
                        <th>Pass Count</th>
                        <th>Fail Count</th>
                        <th>Pass Rate</th>
                        <th>Average Percentage</th>
                        <th>Top Score</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($deptStats as $dept): 
                        $passRate = ($dept['total_results'] > 0) ? round(($dept['pass_count'] / $dept['total_results']) * 100, 1) : 0;
                    ?>
                    <tr>
                        <td class="fw-semibold text-dark"><?php echo htmlspecialchars($dept['department_name']); ?></td>
                        <td><code><?php echo htmlspecialchars($dept['department_code']); ?></code></td>
                        <td><?php echo $dept['total_students']; ?></td>
                        <td><?php echo $dept['total_results']; ?></td>
                        <td><span class="badge bg-success-subtle text-success border border-success"><?php echo $dept['pass_count']; ?></span></td>
                        <td><span class="badge bg-danger-subtle text-danger border border-danger"><?php echo $dept['fail_count']; ?></span></td>
                        <td>
                            <div class="fw-bold text-success"><?php echo $passRate; ?>%</div>
                        </td>
                        <td class="fw-bold text-primary"><?php echo $dept['avg_percentage'] ? $dept['avg_percentage'] : '0.00'; ?>%</td>
                        <td class="fw-bold text-warning"><?php echo $dept['top_percentage'] ? $dept['top_percentage'] : '0.00'; ?>%</td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include(__DIR__ . '/footer.php'); ?>
