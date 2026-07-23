<?php
/**
 * ExamShield – Department Management
 * File: department/view.php
 * Desc: View a single department's full details — purple admin panel
 */
session_start();
require_once '../config/database.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: index.php'); exit();
}
$id   = (int) $_GET['id'];
$stmt = mysqli_prepare($conn,
    "SELECT d.*, i.institute_name, i.institute_code
     FROM department d
     LEFT JOIN institute i ON d.institute_id = i.id
     WHERE d.id = ? LIMIT 1");
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
$dept = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
mysqli_stmt_close($stmt);
if (!$dept) { header('Location: index.php'); exit(); }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($dept['department_name']) ?> | ExamShield</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/dashboard.css">
    <link rel="stylesheet" href="../assets/css/department.css">
</head>
<body>

<nav class="es-navbar">
    <div class="nav-brand"><i class="fa-solid fa-shield-halved"></i><span>ExamShield LPS</span></div>
    <div class="nav-right">
        <button class="nav-bell"><i class="fa-solid fa-bell"></i></button>
        <div class="nav-user">
            <div class="nav-avatar"><i class="fa-solid fa-user"></i></div>
            <span class="nav-user-name"><?= htmlspecialchars($_SESSION['name'] ?? 'Admin') ?></span>
        </div>
    </div>
</nav>

<aside class="es-sidebar">
    <div class="sidebar-logo">
        <div class="logo-icon"><i class="fa-solid fa-shield-halved"></i></div>
        <div class="logo-text"><h6>ExamShield LPS</h6><span>Admin Panel</span></div>
    </div>
    <nav class="sidebar-nav">
        <span class="nav-section-label">Main Menu</span>
        <a class="nav-item" href="#"><i class="fa-solid fa-gauge-high"></i> Dashboard</a>
        <a class="nav-item" href="../institute/index.php"><i class="fa-solid fa-building"></i> Institutes</a>
        <a class="nav-item active" href="index.php"><i class="fa-solid fa-layer-group"></i> Departments</a>
        <span class="nav-section-label">Other Modules</span>
        <a class="nav-item" href="#"><i class="fa-solid fa-users"></i> Users</a>
        <a class="nav-item" href="#"><i class="fa-solid fa-file-pen"></i> Exams</a>
        <a class="nav-item" href="#"><i class="fa-solid fa-chart-bar"></i> Reports</a>
        <a class="nav-item" href="#"><i class="fa-solid fa-bell"></i> Notifications</a>
        <a class="nav-item" href="#"><i class="fa-solid fa-gear"></i> Settings</a>
    </nav>
    <div class="sidebar-footer">
        <a class="nav-item" href="../app/auth/logout.php"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
    </div>
</aside>

<main class="es-content">
    <div class="es-breadcrumb">
        <a href="#"><i class="fa-solid fa-house"></i> Dashboard</a>
        <span class="sep"><i class="fa-solid fa-chevron-right" style="font-size:10px;"></i></span>
        <a href="index.php">Departments</a>
        <span class="sep"><i class="fa-solid fa-chevron-right" style="font-size:10px;"></i></span>
        <span class="current"><?= htmlspecialchars($dept['department_name']) ?></span>
    </div>

    <div class="page-header">
        <div class="page-header-left">
            <h1>Department Details</h1>
            <p class="page-subtitle">Full profile of this department</p>
        </div>
        <div class="d-flex gap-2 flex-wrap">
            <a href="edit.php?id=<?= $id ?>" class="btn-purple"><i class="fa-solid fa-pen-to-square"></i> Edit</a>
            <a href="index.php" class="btn-light-action"><i class="fa-solid fa-arrow-left"></i> Back</a>
        </div>
    </div>

    <!-- Detail Header -->
    <div class="detail-header-card">
        <div class="detail-icon-box"><i class="fa-solid fa-layer-group"></i></div>
        <div class="detail-header-text">
            <h4><?= htmlspecialchars($dept['department_name']) ?></h4>
            <p>
                <?php if (!empty($dept['dept_code'])): ?>
                <span class="code-pill" style="background:rgba(255,255,255,.22);color:white;">
                    <?= htmlspecialchars($dept['dept_code']) ?>
                </span>
                <?php endif; ?>
                &nbsp;
                <?php if ($dept['status'] === 'Active'): ?>
                    <span class="badge-active" style="background:rgba(16,185,129,.25);color:#a7f3d0;">Active</span>
                <?php else: ?>
                    <span class="badge-inactive" style="background:rgba(245,158,11,.25);color:#fde68a;">Inactive</span>
                <?php endif; ?>
            </p>
        </div>
    </div>

    <!-- Info Table -->
    <div class="es-card">
        <div class="es-card-header">
            <h5 class="es-card-title"><i class="fa-solid fa-circle-info"></i> Department Information</h5>
            <div class="action-icons">
                <a href="edit.php?id=<?= $id ?>" class="btn-icon btn-icon-edit" title="Edit">
                    <i class="fa-solid fa-pen-to-square"></i>
                </a>
                <button class="btn-icon btn-icon-delete dept-delete-btn"
                    data-id="<?= $id ?>"
                    data-name="<?= htmlspecialchars($dept['department_name']) ?>" title="Delete">
                    <i class="fa-solid fa-trash"></i>
                </button>
            </div>
        </div>
        <div class="es-card-body">
            <table class="detail-info-table">
                <tr>
                    <th><i class="fa-solid fa-layer-group"></i> Department Name</th>
                    <td><strong><?= htmlspecialchars($dept['department_name']) ?></strong></td>
                </tr>
                <tr>
                    <th><i class="fa-solid fa-hashtag"></i> Department Code</th>
                    <td>
                        <?php if (!empty($dept['dept_code'])): ?>
                            <span class="code-pill"><?= htmlspecialchars($dept['dept_code']) ?></span>
                        <?php else: echo '<span style="color:#94a3b8;">Not set</span>'; endif; ?>
                    </td>
                </tr>
                <tr>
                    <th><i class="fa-solid fa-user-tie"></i> Head of Department</th>
                    <td><?= !empty($dept['hod']) ? htmlspecialchars($dept['hod']) : '<span style="color:#94a3b8;">Not assigned</span>' ?></td>
                </tr>
                <tr>
                    <th><i class="fa-solid fa-building"></i> Institute</th>
                    <td>
                        <?php if (!empty($dept['institute_name'])): ?>
                            <a href="../institute/view.php?id=<?= (int)$dept['institute_id'] ?>" style="color:var(--primary);font-weight:600;">
                                <?= htmlspecialchars($dept['institute_name']) ?>
                                <?php if (!empty($dept['institute_code'])): ?>
                                    <span style="color:#94a3b8;font-weight:400;">(<?= htmlspecialchars($dept['institute_code']) ?>)</span>
                                <?php endif; ?>
                            </a>
                        <?php else: echo '<span style="color:#94a3b8;">Not linked</span>'; endif; ?>
                    </td>
                </tr>
                <tr>
                    <th><i class="fa-solid fa-toggle-on"></i> Status</th>
                    <td>
                        <?php if ($dept['status'] === 'Active'): ?>
                            <span class="badge-active">Active</span>
                        <?php else: ?>
                            <span class="badge-inactive">Inactive</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php if (!empty($dept['created_at'])): ?>
                <tr>
                    <th><i class="fa-solid fa-calendar-days"></i> Created At</th>
                    <td><?= date('d F Y, h:i A', strtotime($dept['created_at'])) ?></td>
                </tr>
                <?php endif; ?>
            </table>
        </div>
    </div>

    <div class="d-flex gap-2 mt-3 flex-wrap">
        <a href="edit.php?id=<?= $id ?>" class="btn-purple"><i class="fa-solid fa-pen-to-square"></i> Edit Department</a>
        <button class="btn-light-action dept-delete-btn"
            data-id="<?= $id ?>"
            data-name="<?= htmlspecialchars($dept['department_name']) ?>">
            <i class="fa-solid fa-trash"></i> Delete
        </button>
        <a href="index.php" class="btn-light-action"><i class="fa-solid fa-list"></i> All Departments</a>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
<script src="../assets/js/dashboard.js"></script>
<script src="../assets/js/department.js"></script>
</body>
</html>
