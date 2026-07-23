<?php
/**
 * ExamShield – Department Module
 * File : department/migrate.php
 * Desc : One-time database migration — adds dept_code, hod, institute_id
 *        columns to the `department` table if they don't already exist.
 *
 * HOW TO USE:
 *   Open in browser once: http://localhost/ExamShield-LPS-/department/migrate.php
 *   Then delete or password-protect this file.
 */

require_once '../config/database.php';

$results = [];

// Safe migration – ALTER TABLE IF NOT EXISTS column (MySQL 8.0+ / MariaDB 10.x)
$migrations = [
    [
        'sql'  => "ALTER TABLE department ADD COLUMN IF NOT EXISTS dept_code VARCHAR(20) NOT NULL DEFAULT '' AFTER department_name",
        'desc' => 'Add dept_code column',
    ],
    [
        'sql'  => "ALTER TABLE department ADD COLUMN IF NOT EXISTS hod VARCHAR(100) NOT NULL DEFAULT '' AFTER dept_code",
        'desc' => 'Add hod (Head of Department) column',
    ],
    [
        'sql'  => "ALTER TABLE department ADD COLUMN IF NOT EXISTS institute_id INT DEFAULT NULL AFTER hod",
        'desc' => 'Add institute_id (FK to institute) column',
    ],
];

foreach ($migrations as $migration) {
    $ok = mysqli_query($conn, $migration['sql']);
    $results[] = [
        'desc'  => $migration['desc'],
        'ok'    => $ok,
        'error' => $ok ? '' : mysqli_error($conn),
    ];
}

mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DB Migration | ExamShield</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background: #f4f6f9; padding: 40px 20px; }
        .mig-card { max-width: 680px; margin: 0 auto; background: white; border-radius: 16px; padding: 36px; box-shadow: 0 8px 30px rgba(0,0,0,.08); }
    </style>
</head>
<body>
<div class="mig-card">
    <h3 class="fw-bold mb-1"><i class="bi bi-database-check"></i> Database Migration</h3>
    <p class="text-muted mb-4">ExamShield – Department Table Upgrade</p>

    <table class="table table-bordered">
        <thead class="table-primary">
            <tr>
                <th>Migration</th>
                <th>Result</th>
                <th>Note</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($results as $r): ?>
            <tr>
                <td><?= htmlspecialchars($r['desc']) ?></td>
                <td>
                    <?php if ($r['ok']): ?>
                        <span class="badge bg-success">OK</span>
                    <?php else: ?>
                        <span class="badge bg-warning text-dark">Skipped / Already exists</span>
                    <?php endif; ?>
                </td>
                <td class="text-muted small">
                    <?= $r['error'] ? htmlspecialchars($r['error']) : 'No errors' ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="alert alert-warning mt-3">
        <strong>Important:</strong> After running migration, please delete or secure this file.
    </div>

    <a href="index.php" class="btn btn-primary mt-2">
        &larr; Go to Department List
    </a>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.css"></script>
</body>
</html>
