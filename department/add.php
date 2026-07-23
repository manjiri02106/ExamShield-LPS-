<?php
/**
 * ExamShield – Department Management
 * File: department/add.php
 * Desc: Add new department — purple admin panel
 */
session_start();
require_once '../config/database.php';

@mysqli_query($conn, "ALTER TABLE department ADD COLUMN IF NOT EXISTS dept_code VARCHAR(20) NOT NULL DEFAULT '' AFTER department_name");
@mysqli_query($conn, "ALTER TABLE department ADD COLUMN IF NOT EXISTS hod VARCHAR(100) NOT NULL DEFAULT '' AFTER dept_code");
@mysqli_query($conn, "ALTER TABLE department ADD COLUMN IF NOT EXISTS institute_id INT DEFAULT NULL AFTER hod");

$institutes = [];
$ir = mysqli_query($conn, "SELECT id, institute_name, institute_code FROM institute ORDER BY institute_name ASC");
while ($row = mysqli_fetch_assoc($ir)) { $institutes[] = $row; }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Department | ExamShield</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
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
        <span class="current">Add Department</span>
    </div>

    <div class="page-header">
        <div class="page-header-left">
            <h1>Add Department</h1>
            <p class="page-subtitle">Register a new department</p>
        </div>
        <a href="index.php" class="btn-light-action"><i class="fa-solid fa-arrow-left"></i> Back to List</a>
    </div>

    <?php if (empty($institutes)): ?>
    <div class="es-flash es-flash-error" style="margin-bottom:20px;">
        <i class="fa-solid fa-triangle-exclamation"></i>
        <strong>No Institute Found.</strong> Please <a href="../institute/add.php" style="color:inherit;font-weight:700;">add an institute</a> first.
    </div>
    <?php endif; ?>

    <div class="es-form-card">
        <div class="es-form-header">
            <h5><i class="fa-solid fa-layer-group"></i> Department Information</h5>
        </div>
        <div class="es-form-body">
            <form id="departmentForm" action="save.php" method="POST" novalidate>

                <div class="es-form-section"><i class="fa-solid fa-circle-info me-2"></i>Basic Information</div>
                <div class="row g-3">
                    <div class="col-md-8">
                        <label class="form-label" for="deptName">Department Name <span class="req">*</span></label>
                        <input type="text" id="deptName" name="department_name" class="form-control"
                            placeholder="e.g. Computer Science & Engineering" maxlength="200" required>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label" for="deptCode">Department Code <span class="req">*</span></label>
                        <input type="text" id="deptCode" name="dept_code" class="form-control"
                            placeholder="e.g. CSE" maxlength="20" required>
                        <div class="invalid-feedback"></div>
                        <div class="form-text">Will be auto-uppercased. Max 20 chars.</div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="hod">Head of Department (HOD) <span class="req">*</span></label>
                        <input type="text" id="hod" name="hod" class="form-control"
                            placeholder="e.g. Dr. Rajesh Sharma" maxlength="100" required>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="status">Status <span class="req">*</span></label>
                        <select id="status" name="status" class="form-select">
                            <option value="Active" selected>Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                    </div>
                </div>

                <div class="es-form-section"><i class="fa-solid fa-building me-2"></i>Institute Assignment</div>
                <div class="row g-3">
                    <div class="col-md-8">
                        <label class="form-label" for="instituteId">Select Institute <span class="req">*</span></label>
                        <select id="instituteId" name="institute_id" class="form-select" required>
                            <option value="">— Select Institute —</option>
                            <?php foreach ($institutes as $inst): ?>
                                <option value="<?= (int)$inst['id'] ?>">
                                    <?= htmlspecialchars($inst['institute_name']) ?>
                                    <?= !empty($inst['institute_code']) ? '(' . htmlspecialchars($inst['institute_code']) . ')' : '' ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="invalid-feedback"></div>
                    </div>
                </div>

                <div class="es-form-actions">
                    <button type="submit" class="btn-purple"><i class="fa-solid fa-floppy-disk"></i> Save Department</button>
                    <a href="index.php" class="btn-light-action"><i class="fa-solid fa-xmark"></i> Cancel</a>
                </div>
            </form>
        </div>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
<script src="../assets/js/dashboard.js"></script>
<script src="../assets/js/department.js"></script>
</body>
</html>