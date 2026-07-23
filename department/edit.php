<?php
/**
 * ExamShield – Department Management
 * File: department/edit.php
 * Desc: Edit an existing department — purple admin panel
 */
session_start();
require_once '../config/database.php';

@mysqli_query($conn, "ALTER TABLE department ADD COLUMN IF NOT EXISTS dept_code VARCHAR(20) NOT NULL DEFAULT '' AFTER department_name");
@mysqli_query($conn, "ALTER TABLE department ADD COLUMN IF NOT EXISTS hod VARCHAR(100) NOT NULL DEFAULT '' AFTER dept_code");
@mysqli_query($conn, "ALTER TABLE department ADD COLUMN IF NOT EXISTS institute_id INT DEFAULT NULL AFTER hod");

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: index.php'); exit();
}
$id   = (int) $_GET['id'];
$stmt = mysqli_prepare($conn, 'SELECT * FROM department WHERE id = ? LIMIT 1');
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
$dept = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
mysqli_stmt_close($stmt);
if (!$dept) { $_SESSION['dept_error'] = 'Department not found.'; header('Location: index.php'); exit(); }

$institutes = [];
$ir = mysqli_query($conn, "SELECT id, institute_name, institute_code FROM institute ORDER BY institute_name ASC");
while ($row = mysqli_fetch_assoc($ir)) { $institutes[] = $row; }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Department | ExamShield</title>
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
        <span class="current">Edit – <?= htmlspecialchars($dept['department_name']) ?></span>
    </div>

    <div class="page-header">
        <div class="page-header-left">
            <h1>Edit Department</h1>
            <p class="page-subtitle">Modify department details</p>
        </div>
        <a href="index.php" class="btn-light-action"><i class="fa-solid fa-arrow-left"></i> Back to List</a>
    </div>

    <div class="es-form-card">
        <div class="es-form-header">
            <h5><i class="fa-solid fa-pen-to-square"></i> Edit – <?= htmlspecialchars($dept['department_name']) ?></h5>
        </div>
        <div class="es-form-body">
            <form id="departmentForm" action="update.php" method="POST" novalidate>
                <input type="hidden" name="id" value="<?= (int)$dept['id'] ?>">

                <div class="es-form-section"><i class="fa-solid fa-circle-info me-2"></i>Basic Information</div>
                <div class="row g-3">
                    <div class="col-md-8">
                        <label class="form-label" for="deptName">Department Name <span class="req">*</span></label>
                        <input type="text" id="deptName" name="department_name" class="form-control"
                            value="<?= htmlspecialchars($dept['department_name']) ?>" maxlength="200" required>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label" for="deptCode">Department Code <span class="req">*</span></label>
                        <input type="text" id="deptCode" name="dept_code" class="form-control"
                            value="<?= htmlspecialchars($dept['dept_code'] ?? '') ?>" maxlength="20" required>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="hod">Head of Department (HOD) <span class="req">*</span></label>
                        <input type="text" id="hod" name="hod" class="form-control"
                            value="<?= htmlspecialchars($dept['hod'] ?? '') ?>" maxlength="100" required>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="status">Status <span class="req">*</span></label>
                        <select id="status" name="status" class="form-select">
                            <option value="Active"   <?= $dept['status']==='Active'   ? 'selected':'' ?>>Active</option>
                            <option value="Inactive" <?= $dept['status']==='Inactive' ? 'selected':'' ?>>Inactive</option>
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
                                <option value="<?= (int)$inst['id'] ?>"
                                    <?= ((int)($dept['institute_id'] ?? 0) === (int)$inst['id']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($inst['institute_name']) ?>
                                    <?= !empty($inst['institute_code']) ? '(' . htmlspecialchars($inst['institute_code']) . ')' : '' ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="invalid-feedback"></div>
                    </div>
                </div>

                <div class="es-form-actions">
                    <button type="submit" class="btn-purple"><i class="fa-solid fa-floppy-disk"></i> Update Department</button>
                    <a href="view.php?id=<?= $id ?>" class="btn-light-action"><i class="fa-solid fa-eye"></i> View</a>
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