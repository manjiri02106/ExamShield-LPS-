<?php
/**
 * ==========================================
 * Student Result Management & Reports
 * Printable Student Marksheet View
 * ==========================================
 */

require_once(__DIR__ . '/database.php');

$resultId = isset($_GET['id']) ? (int)$_GET['id'] : 1;

$resultData = dbFetchOne("
    SELECT 
        r.id, r.marks, r.total_marks, r.percentage, r.status, r.created_at,
        s.id as student_id, s.name as student_name, s.enrollment_no, s.email,
        d.department_name, d.department_code,
        e.exam_name, e.exam_code, e.exam_date
    FROM results r
    JOIN students s ON r.student_id = s.id
    JOIN departments d ON s.department_id = d.id
    JOIN exams e ON r.exam_id = e.id
    WHERE r.id = ?
", [$resultId]);

// Fallback to first available result if ID not found
if (!$resultData) {
    $resultData = dbFetchOne("
        SELECT 
            r.id, r.marks, r.total_marks, r.percentage, r.status, r.created_at,
            s.id as student_id, s.name as student_name, s.enrollment_no, s.email,
            d.department_name, d.department_code,
            e.exam_name, e.exam_code, e.exam_date
        FROM results r
        JOIN students s ON r.student_id = s.id
        JOIN departments d ON s.department_id = d.id
        JOIN exams e ON r.exam_id = e.id
        LIMIT 1
    ");
}

$pageTitle = "Student Marksheet - " . ($resultData ? htmlspecialchars($resultData['student_name']) : "Report");
include(__DIR__ . '/header.php');
?>

<style>
@media print {
    .sidebar, .top-navbar, .app-footer, .no-print {
        display: none !important;
    }
    .main-content {
        margin-left: 0 !important;
    }
    .content-body {
        padding: 0 !important;
    }
    .marksheet-card {
        box-shadow: none !important;
        border: 2px solid #000 !important;
    }
}
</style>

<!-- Action Header Bar -->
<div class="d-flex justify-content-between align-items-center mb-4 no-print">
    <div>
        <a href="results.php" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-arrow-left me-1"></i> Back to Results
        </a>
    </div>
    <div class="d-flex gap-2">
        <button onclick="window.print()" class="btn btn-primary-custom btn-sm">
            <i class="fas fa-print me-1"></i> Print Marksheet
        </button>
        <a href="export_pdf.php?id=<?php echo $resultData ? $resultData['id'] : 0; ?>" target="_blank" class="btn btn-success-custom btn-sm">
            <i class="fas fa-file-pdf me-1"></i> Download PDF
        </a>
    </div>
</div>

<?php if ($resultData): ?>
<!-- Official Marksheet Card -->
<div class="custom-card marksheet-card mx-auto" style="max-width: 850px; background: #ffffff; padding: 2.5rem; border-radius: 16px; border: 1px solid var(--border-color);">
    <!-- Institution Header Banner -->
    <div class="text-center pb-4 mb-4 border-bottom border-2">
        <div class="d-flex align-items-center justify-content-center gap-3 mb-2">
            <div class="bg-primary text-white p-2 rounded-3 fs-3">
                <i class="fas fa-university"></i>
            </div>
            <div>
                <h2 class="fw-bold mb-0 text-dark" style="letter-spacing: 0.5px;">EXAMSHIELD ACADEMIC INSTITUTE</h2>
                <span class="text-muted small">Official Statement of Student Academic Performance</span>
            </div>
        </div>
        <div class="badge bg-dark-subtle text-dark border px-3 py-1 mt-2">OFFICIAL MARKSHEET & TRANSCRIPT</div>
    </div>

    <!-- Student & Exam Details Grid -->
    <div class="row g-3 mb-4 p-3 bg-light rounded-3 border">
        <div class="col-12 col-md-6">
            <table class="table table-borderless table-sm mb-0">
                <tr>
                    <td class="text-muted fw-medium" style="width: 140px;">Student Name:</td>
                    <td class="fw-bold text-dark"><?php echo htmlspecialchars($resultData['student_name']); ?></td>
                </tr>
                <tr>
                    <td class="text-muted fw-medium">Enrollment No:</td>
                    <td><code><?php echo htmlspecialchars($resultData['enrollment_no']); ?></code></td>
                </tr>
                <tr>
                    <td class="text-muted fw-medium">Email Address:</td>
                    <td><?php echo htmlspecialchars($resultData['email']); ?></td>
                </tr>
            </table>
        </div>
        <div class="col-12 col-md-6">
            <table class="table table-borderless table-sm mb-0">
                <tr>
                    <td class="text-muted fw-medium" style="width: 140px;">Department:</td>
                    <td class="fw-bold"><?php echo htmlspecialchars($resultData['department_name']); ?> (<?php echo htmlspecialchars($resultData['department_code']); ?>)</td>
                </tr>
                <tr>
                    <td class="text-muted fw-medium">Examination:</td>
                    <td class="fw-semibold text-primary"><?php echo htmlspecialchars($resultData['exam_name']); ?></td>
                </tr>
                <tr>
                    <td class="text-muted fw-medium">Exam Date:</td>
                    <td><?php echo htmlspecialchars($resultData['exam_date']); ?></td>
                </tr>
            </table>
        </div>
    </div>

    <!-- Marks Breakdown Table -->
    <div class="table-responsive mb-4">
        <table class="table table-bordered text-center align-middle">
            <thead class="table-light">
                <tr>
                    <th>Examination Subject / Module</th>
                    <th>Maximum Marks</th>
                    <th>Marks Obtained</th>
                    <th>Percentage (%)</th>
                    <th>Result Status</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-start fw-semibold py-3">
                        <i class="fas fa-book me-2 text-primary"></i>
                        <?php echo htmlspecialchars($resultData['exam_name']); ?> (<?php echo htmlspecialchars($resultData['exam_code']); ?>)
                    </td>
                    <td class="py-3"><?php echo number_format($resultData['total_marks'], 2); ?></td>
                    <td class="py-3 fw-bold fs-5 text-dark"><?php echo number_format($resultData['marks'], 2); ?></td>
                    <td class="py-3 fw-bold fs-5 text-primary"><?php echo number_format($resultData['percentage'], 2); ?>%</td>
                    <td class="py-3">
                        <?php if ($resultData['status'] === 'Pass'): ?>
                            <span class="badge-status badge-pass px-3 py-2 fs-6"><i class="fas fa-check-circle me-1"></i> PASS</span>
                        <?php else: ?>
                            <span class="badge-status badge-fail px-3 py-2 fs-6"><i class="fas fa-times-circle me-1"></i> FAIL</span>
                        <?php endif; ?>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Summary Box & Grade Info -->
    <div class="row align-items-center mb-5 p-3 rounded-3 border bg-body-tertiary">
        <div class="col-md-7">
            <h6 class="fw-bold mb-1"><i class="fas fa-info-circle text-info me-1"></i> Evaluation Standards</h6>
            <p class="small text-muted mb-0">
                Minimum pass criteria requires a score percentage of <strong>40.00%</strong> or above.<br>
                Issued by ExamShield LPS Examination Cell under standard evaluation protocol.
            </p>
        </div>
        <div class="col-md-5 text-md-end mt-3 mt-md-0">
            <div class="text-muted small">Final Result Status</div>
            <div class="fs-4 fw-bold <?php echo $resultData['status'] === 'Pass' ? 'text-success' : 'text-danger'; ?>">
                <?php echo strtoupper($resultData['status']); ?> (<?php echo number_format($resultData['percentage'], 2); ?>%)
            </div>
        </div>
    </div>

    <!-- Signature & Seal Area -->
    <div class="row pt-4 mt-5 border-top">
        <div class="col-4 text-center">
            <div style="height: 45px;"></div>
            <hr class="w-75 mx-auto my-1">
            <small class="text-muted fw-semibold">Class Coordinator</small>
        </div>
        <div class="col-4 text-center">
            <div style="height: 45px;" class="d-flex align-items-center justify-content-center">
                <span class="badge bg-success-subtle text-success border border-success border-opacity-50 px-3 py-2 rounded-circle">
                    <i class="fas fa-stamp fs-4"></i>
                </span>
            </div>
            <hr class="w-75 mx-auto my-1">
            <small class="text-muted fw-semibold">Controller of Exams</small>
        </div>
        <div class="col-4 text-center">
            <div style="height: 45px;"></div>
            <hr class="w-75 mx-auto my-1">
            <small class="text-muted fw-semibold">Principal / Director</small>
        </div>
    </div>
</div>
<?php else: ?>
<div class="alert alert-warning text-center py-4">
    <i class="fas fa-exclamation-triangle fs-3 d-block mb-2"></i>
    Student mark-sheet record not found.
</div>
<?php endif; ?>

<?php include(__DIR__ . '/footer.php'); ?>
